<?php
include '../DataBase/dbconnect.php';
session_start();

if (isset($_GET['spid']) && isset($_GET['loginid'])) {
    $sp_id = $_GET['spid'];
    $login_id = $_GET['loginid'];

    // Restore: Update login status to 'active' AND reset request flag
    $sql = "UPDATE `login` SET `account_status` = 'active', `activation_request` = 0 WHERE `login_id` = '$login_id'";
    $result = mysqli_query($conn, $sql);

    // Restore SP status as well
    $sql2 = "UPDATE `sp` SET `status` = 'active' WHERE `sp_id` = '$sp_id'";
    $result2 = mysqli_query($conn, $sql2);

    if ($result && $result2) {
        $_SESSION['status'] = "Service Provider Restored Successfully.";
    } else {
        $_SESSION['statusfail'] = "Failed to Restore Service Provider.";
    }
} else {
    $_SESSION['statusfail'] = "Invalid Request.";
}

header("Location: sp_trash.php");
?>