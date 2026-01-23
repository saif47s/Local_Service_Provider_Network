<?php
// connecting to the database
$server = "localhost";
$username = "root"; // The default username in XAMPP
$password = ""; // XAMPP's MySQL password for 'root' is usually empty
$database = "hs"; // Ensure this matches the actual database name

// create a connection
$conn = mysqli_connect($server, $username, $password, $database);

// Die if connecton was not successful
if (!$conn) {
    die("Sorry! We failed to connect: " . mysqli_connect_error());
} else {
    // echo "connection successful!<br>";

    // AUTO-UPDATE: Check if OTP columns exist, if not, create them.
    $check_col = mysqli_query($conn, "SHOW COLUMNS FROM `login` LIKE 'is_verified'");
    if (mysqli_num_rows($check_col) == 0) {
        mysqli_query($conn, "ALTER TABLE `login` ADD COLUMN `is_verified` INT DEFAULT 0 AFTER `role_id`");
        mysqli_query($conn, "ALTER TABLE `login` ADD COLUMN `verification_code` VARCHAR(6) NULL AFTER `is_verified`");
    }
}
?>