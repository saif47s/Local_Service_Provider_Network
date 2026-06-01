<?php
include '../DataBase/dbconnect.php';
session_start();

if (isset($_GET['id'])) {
    $login_id = $_GET['id'];

    // Soft Delete: Update status to 'deleted'
    // This keeps all data (Customer info + Orders) intact but prevents login and hides from view.
    $sql = "UPDATE `login` SET `account_status` = 'deleted', `deletion_request` = 0, `activation_request` = 0 WHERE `login_id` = '$login_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['status'] = "Customer Soft Deleted (Deactivated) Successfully. Data is Safe.";
    } else {
        $_SESSION['statusfail'] = "Failed to Deactivate Customer.";
    }
} else {
    $_SESSION['statusfail'] = "Invalid Request.";
}

header("Location: customer_view.php");
?>