<?php
include '../DataBase/dbconnect.php';
session_start();

if (isset($_GET['spid']) && isset($_GET['loginid'])) {
    $sp_id = $_GET['spid'];
    $login_id = $_GET['loginid'];

    // 1. Delete Related Data (e.g., Services, Gigs)
    // Assuming we should clean up services offered by this SP
    /* 
    $del_services = "DELETE FROM service WHERE sp_id = '$sp_id'";
    mysqli_query($conn, $del_services); 
    */
    // For now, mirroring basic deletion. If detailed constraints exist, add them here.

    // 2. Delete SP Profile
    $del_sp = "DELETE FROM sp WHERE sp_id = '$sp_id'";
    $result_sp = mysqli_query($conn, $del_sp);

    // 3. Delete Login Credentials
    $del_login = "DELETE FROM login WHERE login_id = '$login_id'";
    $result_login = mysqli_query($conn, $del_login);

    if ($result_sp && $result_login) {
        $_SESSION['status'] = "Service Provider Permanently Deleted.";
    } else {
        $_SESSION['statusfail'] = "Failed to Delete Service Provider.";
    }
} else {
    $_SESSION['statusfail'] = "Invalid Request.";
}

header("Location: sp_trash.php");
?>