<?php
include '../DataBase/dbconnect.php';
session_start();

if (isset($_GET['spid']) && isset($_GET['loginid'])) {
    $sp_id = $_GET['spid'];
    $login_id = $_GET['loginid'];

    // Soft Delete: Update login status to 'deleted'
    // We also set SP status to 'deactive' so they don't appear in public lists if any query checks that
    $sql = "UPDATE `login` SET `account_status` = 'deleted' WHERE `login_id` = '$login_id'";
    $result = mysqli_query($conn, $sql);

    // Optional: Also mark SP table as deactive for consistency
    $sql_sp = "UPDATE `sp` SET `status` = 'deactive' WHERE `sp_id` = '$sp_id'";
    mysqli_query($conn, $sql_sp);

    if ($result) {
        $_SESSION['status'] = "Service Provider moved to Trash (Soft Deleted).";
    } else {
        $_SESSION['statusfail'] = "Failed to delete Service Provider.";
    }
} else {
    $_SESSION['statusfail'] = "Invalid Request.";
}

header("location: sp_view.php");
?>