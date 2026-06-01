<?php
define('MYSITE', true);
include '../db/dbconnect.php';
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_order'])) {
    $order_id = (int)$_POST['order_id'];
    $customer_id = (int)$_SESSION['customer_id'];

    if ($order_id > 0 && $customer_id > 0) {
        // Verify ownership
        $check_sql = "SELECT * FROM `order_master` WHERE `order_id` = $order_id AND `customer_id` = $customer_id";
        $check_res = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_res) > 0) {
            // Update status of pending or inprogress items to 'cancelled'
            $cancel_sql = "UPDATE `user_order` SET `status` = 'cancelled' WHERE `order_id` = $order_id AND (`status` = 'pending' OR `status` = 'inprogress')";
            
            if (mysqli_query($conn, $cancel_sql)) {
                $_SESSION['cancel_success'] = "Order #$order_id has been cancelled successfully.";
            } else {
                $_SESSION['cancel_error'] = "Failed to cancel order #$order_id.";
            }
        } else {
            $_SESSION['cancel_error'] = "Order not found or unauthorized access.";
        }
    } else {
        $_SESSION['cancel_error'] = "Invalid order or customer session.";
    }
}

header("location: order_details.php");
exit;
?>
