<?php
header('Content-Type: application/json');

session_start();
include '../DataBase/dbconnect.php';

$response = ['order_id' => null, 'sp_id' => null];

if (!isset($_SESSION['sp_loggedin']) || $_SESSION['sp_loggedin'] != true) {
    echo json_encode($response);
    exit;
}

$sp_id = intval($_SESSION['sp_id']);
$response['sp_id'] = $sp_id;

// Try to find the latest order for this service provider (by order_master.order_id descending)
$query = "SELECT om.order_id FROM order_master om WHERE om.order_id IN (SELECT uo.order_id FROM user_order uo WHERE uo.sp_id = $sp_id) ORDER BY om.order_id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row && isset($row['order_id'])) {
        $response['order_id'] = intval($row['order_id']);
    }
}

echo json_encode($response);
