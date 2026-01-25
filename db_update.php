<?php
include 'DataBase/dbconnect.php';

// SQL to add columns if they don't exist
$sql = "SHOW COLUMNS FROM `login` LIKE 'verification_code'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    // Column doesn't exist, add it
    $alterSql = "ALTER TABLE `login` 
                 ADD `verification_code` VARCHAR(255) NOT NULL AFTER `password`,
                 ADD `is_verified` TINYINT(1) NOT NULL DEFAULT '0' AFTER `verification_code`";

    if (mysqli_query($conn, $alterSql)) {
        echo "Success: 'verification_code' and 'is_verified' columns added to 'login' table.<br>";
    } else {
        echo "Error adding columns: " . mysqli_error($conn) . "<br>";
    }
} else {
    // Column exists, check if needs modification
    $row = mysqli_fetch_assoc($result);
    // Type is usually like "varchar(10)"
    if (strpos(strtolower($row['Type']), 'varchar(255)') === false) {
        $modifySql = "ALTER TABLE `login` MODIFY `verification_code` VARCHAR(255) NOT NULL";
        if (mysqli_query($conn, $modifySql)) {
            echo "Success: 'verification_code' column updated to VARCHAR(255).<br>";
        } else {
            echo "Error updating column length: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "Columns already exist and have correct length.<br>";
    }
}

echo "Database update check complete.<br>";
// Link back to home
echo '<br><a href="../index.php">Go to Home</a>';
?>