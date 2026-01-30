<?php
include 'DataBase/dbconnect.php';

// 1. Add 'email' column
$check_email = mysqli_query($conn, "SHOW COLUMNS FROM `login` LIKE 'email'");
if (mysqli_num_rows($check_email) == 0) {
    $sql = "ALTER TABLE `login` ADD COLUMN `email` VARCHAR(255) NULL AFTER `password`";
    if (mysqli_query($conn, $sql)) {
        echo "Column 'email' added successfully.<br>";
    } else {
        echo "Error adding 'email' column: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Column 'email' already exists.<br>";
}

// 2. Add 'otp' column
$check_otp = mysqli_query($conn, "SHOW COLUMNS FROM `login` LIKE 'otp'");
if (mysqli_num_rows($check_otp) == 0) {
    $sql = "ALTER TABLE `login` ADD COLUMN `otp` VARCHAR(6) NULL AFTER `email`";
    if (mysqli_query($conn, $sql)) {
        echo "Column 'otp' added successfully.<br>";
    } else {
        echo "Error adding 'otp' column: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Column 'otp' already exists.<br>";
}

// 3. Update Admin Email
$admin_email = "labpc4472@gmail.com";
$role_sql = "SELECT role_id FROM role WHERE role_name='admin'";
$role_result = mysqli_query($conn, $role_sql);
if ($role_result && mysqli_num_rows($role_result) > 0) {
    $role_row = mysqli_fetch_assoc($role_result);
    $admin_role_id = $role_row['role_id'];

    $update_sql = "UPDATE `login` SET `email`='$admin_email' WHERE `role_id`='$admin_role_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "Admin email updated to '$admin_email'.<br>";
    } else {
        echo "Error updating admin email: " . mysqli_error($conn) . "<br>";
    }
} else {
    echo "Admin role not found.<br>";
}
?>