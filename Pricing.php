<?php

class Pricing
{
    private $conn;
    private $minMultiplier = 0.80;
    private $maxMultiplier = 3.00;
    private $roundPrecision = 2;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function calculateDynamicPrice($serviceId, $areaId, $requestTime = null, $urgency = 'normal', $overrideBasePrice = null, $spId = null)
    {
        if (!$requestTime) {
            $requestTime = date('Y-m-d H:i:s');
        }

        $serviceId = (int) $serviceId;
        $areaId = (int) $areaId;
        $urgency = $this->normalizeUrgency($urgency);

        if ($serviceId <= 0 || $areaId <= 0) {
            return ['success' => false, 'message' => 'Invalid service or area'];
        }

        $basePrice = 0;
        if ($overrideBasePrice !== null && (float) $overrideBasePrice > 0) {
            $basePrice = (float) $overrideBasePrice;
        } else {
            $basePrice = $this->getBasePrice($serviceId);
        }

        if ($basePrice <= 0) {
            return ['success' => false, 'message' => 'Service base price not configured'];
        }

        $zoneMultiplier = $this->getZoneMultiplier($serviceId, $areaId);
        $timeMultiplier = $this->getTimeMultiplier($requestTime);
        $demandMultiplier = $this->getDemandMultiplier($serviceId, $areaId, $requestTime);
        $urgencyMultiplier = $this->getUrgencyMultiplier($urgency);
        $availabilityMultiplier = $this->getAvailabilityMultiplier($serviceId, $areaId, $requestTime, $spId);

        $rawComposite = $zoneMultiplier * $timeMultiplier * $demandMultiplier * $urgencyMultiplier * $availabilityMultiplier;
        $compositeMultiplier = $this->clampMultiplier($rawComposite);
        $finalPrice = round($basePrice * $compositeMultiplier, $this->roundPrecision);

        return [
            'success' => true,
            'data' => [
                'base_price' => round($basePrice, $this->roundPrecision),
                'final_price' => $finalPrice,
                'breakdown' => [
                    'base_price' => round($basePrice, $this->roundPrecision),
                    'multipliers' => [
                        'zone' => $zoneMultiplier,
                        'time' => $timeMultiplier,
                        'demand' => $demandMultiplier,
                        'urgency' => $urgencyMultiplier,
                        'availability' => $availabilityMultiplier
                    ],
                    'raw_composite_multiplier' => round($rawComposite, 4),
                    'composite_multiplier' => round($compositeMultiplier, 4),
                    'guardrails' => [
                        'min_cap' => $this->minMultiplier,
                        'max_cap' => $this->maxMultiplier,
                        'fallback_multiplier' => 1.0,
                        'decimal_rounding' => $this->roundPrecision
                    ],
                    'urgency' => $urgency
                ]
            ]
        ];
    }

    private function getBasePrice($serviceId)
    {
        $sql = "SELECT base_price FROM service WHERE service_id = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            return 0;
        }
        mysqli_stmt_bind_param($stmt, "i", $serviceId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = $result ? mysqli_fetch_assoc($result) : null;
        mysqli_stmt_close($stmt);
        return $row ? (float) $row['base_price'] : 0;
    }

    private function getZoneMultiplier($serviceId, $areaId)
    {
        $sql = "SELECT multiplier
                FROM pricing_rules
                WHERE status = 'active'
                  AND rule_type = 'zone'
                  AND area_id = ?
                  AND (service_id = ? OR service_id IS NULL)
                ORDER BY service_id DESC
                LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            return 1.0;
        }
        mysqli_stmt_bind_param($stmt, "ii", $areaId, $serviceId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = $result ? mysqli_fetch_assoc($result) : null;
        mysqli_stmt_close($stmt);
        return $row ? $this->sanitizeMultiplier($row['multiplier']) : 1.0;
    }

    private function getTimeMultiplier($requestTime)
    {
        $hour = (int) date('H', strtotime($requestTime));
        $dayOfWeek = (int) date('N', strtotime($requestTime));

        if (($hour >= 8 && $hour <= 10) || ($hour >= 18 && $hour <= 20)) {
            return 1.2;
        }
        if ($dayOfWeek >= 6) {
            return 1.15;
        }
        if ($hour >= 22 || $hour <= 6) {
            return 1.3;
        }
        return 1.0;
    }

    private function getDemandMultiplier($serviceId, $areaId, $requestTime)
    {
        $sql = "SELECT COUNT(*) AS req_count
                FROM user_order uo
                INNER JOIN order_master om ON om.order_id = uo.order_id
                WHERE uo.service_id = ?
                  AND om.area_id = ?
                  AND om.order_date >= DATE_SUB(?, INTERVAL 2 HOUR)";
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            return 1.0;
        }
        mysqli_stmt_bind_param($stmt, "iis", $serviceId, $areaId, $requestTime);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = $result ? mysqli_fetch_assoc($result) : null;
        mysqli_stmt_close($stmt);
        $requestCount = $row ? (int) $row['req_count'] : 0;

        if ($requestCount > 5) {
            return 1.5;
        }
        if ($requestCount >= 3) {
            return 1.2;
        }
        return 1.0;
    }

    private function getUrgencyMultiplier($urgency)
    {
        if ($urgency === 'emergency') {
            return 2.0;
        }
        if ($urgency === 'urgent') {
            return 1.5;
        }
        return 1.0;
    }

    private function getAvailabilityMultiplier($serviceId, $areaId, $requestTime, $spId = null)
    {
        $requestDate = date('Y-m-d', strtotime($requestTime));

        // If a specific SP is provided, check ONLY their availability
        if ($spId !== null && $spId > 0) {
            $sql = "SELECT COUNT(*) as busy_count
                    FROM user_order uo
                    INNER JOIN order_master om ON om.order_id = uo.order_id
                    WHERE uo.sp_id = ?
                      AND DATE(om.due_date) = ?
                      AND uo.status IN ('pending', 'inprogress')";
            $stmt = mysqli_prepare($this->conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "is", $spId, $requestDate);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = $result ? mysqli_fetch_assoc($result) : null;
                mysqli_stmt_close($stmt);
                $busyCount = $row ? (int) $row['busy_count'] : 0;
                
                if ($busyCount > 0) {
                    return 1.5; // Critical: Specific SP is busy on this day
                }
                return 1.0; // Specific SP is free
            }
        }

        // Count providers who are NOT busy on this day
        // A provider is "busy" if they have an order with status 'pending' or 'inprogress' on $requestDate
        $sql = "SELECT COUNT(DISTINCT sp.sp_id) AS provider_count
                FROM sp
                INNER JOIN sp_service sps ON sps.sp_id = sp.sp_id
                WHERE sps.service_id = ?
                  AND sps.availability = 1
                  AND sp.status = 'active'
                  AND sp.area_id = ?
                  AND sp.sp_id NOT IN (
                      SELECT uo.sp_id
                      FROM user_order uo
                      INNER JOIN order_master om ON om.order_id = uo.order_id
                      WHERE DATE(om.due_date) = ?
                        AND uo.status IN ('pending', 'inprogress')
                  )";
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            return 1.0;
        }
        mysqli_stmt_bind_param($stmt, "iis", $serviceId, $areaId, $requestDate);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = $result ? mysqli_fetch_assoc($result) : null;
        mysqli_stmt_close($stmt);
        $providerCount = $row ? (int) $row['provider_count'] : 0;

        if ($providerCount <= 0) {
            return 1.5; // Critical: No free providers available
        }
        if ($providerCount == 1) {
            return 1.2; // Low: Only 1 free provider available
        }
        // If 2 or more free providers, no surcharge
        return 1.0;
    }

    private function normalizeUrgency($urgency)
    {
        $urgency = strtolower(trim((string) $urgency));
        if (!in_array($urgency, ['normal', 'urgent', 'emergency'], true)) {
            return 'normal';
        }
        return $urgency;
    }

    private function sanitizeMultiplier($value)
    {
        $multiplier = (float) $value;
        if ($multiplier <= 0) {
            return 1.0;
        }
        return $multiplier;
    }

    private function clampMultiplier($multiplier)
    {
        if ($multiplier < $this->minMultiplier) {
            return $this->minMultiplier;
        }
        if ($multiplier > $this->maxMultiplier) {
            return $this->maxMultiplier;
        }
        return $multiplier;
    }
}

?>