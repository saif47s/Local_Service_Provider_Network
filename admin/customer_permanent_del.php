<?php
include '../DataBase/dbconnect.php';
session_start();

if (isset($_GET['id'])) {
    $login_id = $_GET['id'];

    // Get customer_id first to delete related orders
    $cust_query = "SELECT customer_id FROM customer WHERE login_id = '$login_id'";
    $cust_result = mysqli_query($conn, $cust_query);

    if ($cust_result && mysqli_num_rows($cust_result) > 0) {
        $row = mysqli_fetch_assoc($cust_result);
        $customer_id = $row['customer_id'];

        // 1. Delete Orders (order_master)
        $del_orders = "DELETE FROM order_master WHERE customer_id = '$customer_id'";
        mysqli_query($conn, $del_orders);

        // 2. Delete Customer Profile
        $del_customer = "DELETE FROM customer WHERE customer_id = '$customer_id'";
        mysqli_query($conn, $del_customer);
    }

    // 3. Delete Login Credentials (Primary action based on login_id)
    $del_login = "DELETE FROM login WHERE login_id = '$login_id'";
    $result = mysqli_query($conn, $del_login);

    if ($result) {
        $_SESSION['status'] = "Customer Permanently Deleted (Including all records).";
    } else {
        $_SESSION['statusfail'] = "Failed to Delete Customer Permanently.";
    }
} else {
    $_SESSION['statusfail'] = "Invalid Request.";
}

header("Location: customer_trash.php");
?>