<?php
include __DIR__ . '/../DataBase/dbconnect.php';

// Add verification columns to login table
$sql1 = "ALTER TABLE `login` ADD COLUMN `is_verified` INT DEFAULT 0 AFTER `role_id`";
$sql2 = "ALTER TABLE `login` ADD COLUMN `verification_code` VARCHAR(6) NULL AFTER `is_verified`";

// Execute
if (mysqli_query($conn, $sql1)) {
    echo "Column 'is_verified' added successfully.\n";
} else {
    echo "Error adding 'is_verified': " . mysqli_error($conn) . "\n";
}

if (mysqli_query($conn, $sql2)) {
    echo "Column 'verification_code' added successfully.\n";
} else {
    echo "Error adding 'verification_code': " . mysqli_error($conn) . "\n";
}

mysqli_close($conn);
?>