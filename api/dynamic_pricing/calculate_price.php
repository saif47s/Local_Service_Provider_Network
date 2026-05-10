<?php
header('Content-Type: application/json');

include __DIR__ . '/../../DataBase/dbconnect.php';
require_once __DIR__ . '/../../Pricing.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$serviceId = isset($_POST['service_id']) ? (int) $_POST['service_id'] : 0;
$areaId = isset($_POST['area_id']) ? (int) $_POST['area_id'] : 0;
$basePrice = isset($_POST['base_price']) ? (float) $_POST['base_price'] : null;
$spId = isset($_POST['sp_id']) ? (int) $_POST['sp_id'] : null;
$urgency = isset($_POST['urgency']) ? trim($_POST['urgency']) : 'normal';
$requestTime = isset($_POST['request_time']) && $_POST['request_time'] !== '' ? $_POST['request_time'] : date('Y-m-d H:i:s');

if ($serviceId <= 0 || $areaId <= 0) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'service_id and area_id are required']);
    exit;
}

$pricing = new Pricing($conn);
$result = $pricing->calculateDynamicPrice($serviceId, $areaId, $requestTime, $urgency, $basePrice, $spId);

if (!$result['success']) {
    http_response_code(422);
}

echo json_encode($result);
?>
