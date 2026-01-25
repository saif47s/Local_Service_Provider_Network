<?php
include '../DataBase/dbconnect.php';

// SQL to add column if it doesn't exist
$sql = "SHOW COLUMNS FROM `login` LIKE 'activation_request'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    $alter_sql = "ALTER TABLE `login` ADD `activation_request` INT NOT NULL DEFAULT '0'";
    if (mysqli_query($conn, $alter_sql)) {
        echo "Column 'activation_request' added successfully.";
    } else {
        echo "Error adding column: " . mysqli_error($conn);
    }
} else {
    echo "Column 'activation_request' already exists.";
}
?>