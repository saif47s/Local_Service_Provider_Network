<?php
include '../DataBase/dbconnect.php';

// Check if column exists
$check = "SHOW COLUMNS FROM `login` LIKE 'account_status'";
$result = mysqli_query($conn, $check);

if (mysqli_num_rows($result) == 0) {
    // Add column if not exists
    $sql = "ALTER TABLE `login` ADD COLUMN `account_status` VARCHAR(20) DEFAULT 'active'";
    if (mysqli_query($conn, $sql)) {
        echo "Success: 'account_status' column added to 'login' table.";
    } else {
        echo "Error adding column: " . mysqli_error($conn);
    }
} else {
    echo "Column 'account_status' already exists.";
}
?>