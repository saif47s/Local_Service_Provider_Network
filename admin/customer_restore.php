<?php
include '../DataBase/dbconnect.php';
session_start();

if (isset($_GET['id'])) {
    $login_id = $_GET['id'];

    // Restore: Update status to 'active'
    $sql = "UPDATE `login` SET `account_status` = 'active' WHERE `login_id` = '$login_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['status'] = "Customer Restored (Activated) Successfully. They can login now.";
    } else {
        $_SESSION['statusfail'] = "Failed to Restore Customer.";
    }
} else {
    $_SESSION['statusfail'] = "Invalid Request.";
}

header("Location: customer_trash.php");
?>