<?php
session_start();
include '../db/dbconnect.php';
require_once '../Pricing.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order'])) {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
            echo "<script>window.location.href = '../login.php';</script>";
            exit;
        }

        $customer_id = (int) $_SESSION['customer_id'];
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name'] ?? $_POST['fullname'] ?? '');
        $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
        $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
        $pincode = mysqli_real_escape_string($conn, $_POST['pincode'] ?? '');
        $pay_mode = mysqli_real_escape_string($conn, $_POST['pay_mode'] ?? 'COD');
        $due_date = mysqli_real_escape_string($conn, $_POST['due_date'] ?? date('Y-m-d H:i:s'));
        $area_id = (int) ($_POST['area_id'] ?? 0);
        $urgency = mysqli_real_escape_string($conn, $_POST['urgency'] ?? 'normal');
        date_default_timezone_set('Asia/Kolkata');
        $order_date = date('Y-m-d H:i:s');

        if ($area_id <= 0) {
            echo "<script>alert('Please select area/zone first.');window.location.href='mycart.php';</script>";
            exit;
        }

        $pricing = new Pricing($conn);
        $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $base_total = 0.0;
        $dynamic_total = 0.0;
        $itemRows = [];
        $orderBreakdown = [];

        foreach ($cartItems as $value) {
            $service_id = (int) ($value['service_id'] ?? 0);
            $sp_id = (int) ($value['sp_id'] ?? 0);
            $service_title = mysqli_real_escape_string($conn, $value['service_title'] ?? '');
            $quantity = (int) ($value['quantity'] ?? 1);
            $fallbackPrice = (float) ($value['price'] ?? 0);

            $pricingResult = $pricing->calculateDynamicPrice($service_id, $area_id, $due_date, $urgency, $fallbackPrice, $sp_id);
            $base_price = $fallbackPrice;
            $final_price = $fallbackPrice;
            $breakdown = ['note' => 'fallback'];

            if ($pricingResult['success']) {
                $base_price = (float) $pricingResult['data']['base_price'];
                $final_price = (float) $pricingResult['data']['final_price'];
                $breakdown = $pricingResult['data']['breakdown'];
            }

            $base_total += ($base_price * $quantity);
            $dynamic_total += ($final_price * $quantity);
            $orderBreakdown[] = [
                'service_id' => $service_id,
                'service_title' => $service_title,
                'qty' => $quantity,
                'base_price' => round($base_price, 2),
                'final_price' => round($final_price, 2),
                'breakdown' => $breakdown
            ];

            $itemRows[] = [
                'service_id' => $service_id,
                'sp_id' => $sp_id,
                'service_title' => $service_title,
                'qty' => $quantity,
                'base_price' => round($base_price, 2),
                'final_price' => round($final_price, 2),
                'breakdown' => json_encode($breakdown)
            ];
        }

        $commission = round($dynamic_total * 0.05, 2);
        $total = round($dynamic_total + $commission, 2);
        $dynamicMultiplierTotal = $base_total > 0 ? ($dynamic_total / $base_total) : 1.0;

        mysqli_begin_transaction($conn);
        try {
            $masterSql = "INSERT INTO `order_master`
                (`customer_id`,`full_name`,`phone`,`address`,`pincode`,`area_id`,`pay_mode`,`urgency_level`,`total`,`base_total`,`dynamic_multiplier_total`,`dynamic_breakdown`,`commission`,`order_date`,`due_date`)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $masterStmt = mysqli_prepare($conn, $masterSql);
            $dynamicBreakdownJson = json_encode($orderBreakdown);
            mysqli_stmt_bind_param(
                $masterStmt,
                "issssissdddssss",
                $customer_id,
                $full_name,
                $phone,
                $address,
                $pincode,
                $area_id,
                $pay_mode,
                $urgency,
                $total,
                $base_total,
                $dynamicMultiplierTotal,
                $dynamicBreakdownJson,
                $commission,
                $order_date,
                $due_date
            );
            mysqli_stmt_execute($masterStmt);
            $order_id = mysqli_insert_id($conn);
            mysqli_stmt_close($masterStmt);

            $itemSql = "INSERT INTO `user_order`
                (`order_id`,`service_id`,`sp_id`,`service_title`,`price`,`base_price`,`final_price`,`price_breakdown`,`qty`,`status`)
                VALUES (?,?,?,?,?,?,?,?,?,?)";
            $itemStmt = mysqli_prepare($conn, $itemSql);
            $status = 'pending';
            foreach ($itemRows as $row) {
                mysqli_stmt_bind_param(
                    $itemStmt,
                    "iiisdddsis",
                    $order_id,
                    $row['service_id'],
                    $row['sp_id'],
                    $row['service_title'],
                    $row['final_price'],
                    $row['base_price'],
                    $row['final_price'],
                    $row['breakdown'],
                    $row['qty'],
                    $status
                );
                mysqli_stmt_execute($itemStmt);
            }
            mysqli_stmt_close($itemStmt);

            mysqli_commit($conn);
            unset($_SESSION['cart']);
            echo '<script>window.location.href="order_placed.php?order_id=' . $order_id . '&customer_id=' . $customer_id . '";</script>';
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo '<script>alert("Order failed");window.location.href="mycart.php";</script>';
        }
    }
}
