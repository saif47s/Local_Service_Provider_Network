<?php
// connecting to the database
$server = "localhost";
$username = "root"; // The default username in XAMPP
$password = ""; // XAMPP's MySQL password for 'root' is usually empty
$database = "hs"; // Ensure this matches the actual database name

// create a connection
$conn = mysqli_connect($server, $username, $password, $database);

function dp_table_exists($conn, $tableName)
{
    $tableName = mysqli_real_escape_string($conn, $tableName);
    $result = mysqli_query($conn, "SHOW TABLES LIKE '$tableName'");
    return $result && mysqli_num_rows($result) > 0;
}

function dp_column_exists($conn, $tableName, $columnName)
{
    $tableName = mysqli_real_escape_string($conn, $tableName);
    $columnName = mysqli_real_escape_string($conn, $columnName);
    $result = mysqli_query($conn, "SHOW COLUMNS FROM `$tableName` LIKE '$columnName'");
    return $result && mysqli_num_rows($result) > 0;
}

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

    // AUTO-UPDATE: Dynamic pricing schema bootstrap
    if (dp_table_exists($conn, 'service') && !dp_column_exists($conn, 'service', 'base_price')) {
        mysqli_query($conn, "ALTER TABLE `service` ADD COLUMN `base_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `service_name`");
    }

    if (dp_table_exists($conn, 'service') && dp_table_exists($conn, 'sp_service')) {
        mysqli_query(
            $conn,
            "UPDATE `service` s
             LEFT JOIN (
                 SELECT service_id, AVG(CAST(price AS DECIMAL(10,2))) AS avg_price
                 FROM sp_service
                 GROUP BY service_id
             ) p ON p.service_id = s.service_id
             SET s.base_price = COALESCE(p.avg_price, 0.00)
             WHERE s.base_price = 0.00"
        );
    }

    if (!dp_table_exists($conn, 'pricing_rules')) {
        mysqli_query(
            $conn,
            "CREATE TABLE `pricing_rules` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `service_id` INT NULL,
                `area_id` INT NOT NULL,
                `rule_type` ENUM('zone','time','demand','urgency','availability') NOT NULL DEFAULT 'zone',
                `multiplier` DECIMAL(5,2) NOT NULL DEFAULT 1.00,
                `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
                `description` VARCHAR(255) NULL,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                INDEX `idx_pricing_rules_lookup` (`status`, `rule_type`, `area_id`, `service_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
        );
    }

    if (dp_table_exists($conn, 'order_master')) {
        if (!dp_column_exists($conn, 'order_master', 'area_id')) {
            mysqli_query($conn, "ALTER TABLE `order_master` ADD COLUMN `area_id` INT NULL AFTER `pincode`");
        }
        if (!dp_column_exists($conn, 'order_master', 'urgency_level')) {
            mysqli_query($conn, "ALTER TABLE `order_master` ADD COLUMN `urgency_level` ENUM('normal','urgent','emergency') NOT NULL DEFAULT 'normal' AFTER `pay_mode`");
        }
        if (!dp_column_exists($conn, 'order_master', 'base_total')) {
            mysqli_query($conn, "ALTER TABLE `order_master` ADD COLUMN `base_total` DECIMAL(10,2) NULL AFTER `total`");
        }
        if (!dp_column_exists($conn, 'order_master', 'dynamic_multiplier_total')) {
            mysqli_query($conn, "ALTER TABLE `order_master` ADD COLUMN `dynamic_multiplier_total` DECIMAL(8,4) NULL AFTER `base_total`");
        }
        if (!dp_column_exists($conn, 'order_master', 'dynamic_breakdown')) {
            mysqli_query($conn, "ALTER TABLE `order_master` ADD COLUMN `dynamic_breakdown` LONGTEXT NULL AFTER `dynamic_multiplier_total`");
        }
    }

    if (dp_table_exists($conn, 'sp') && !dp_column_exists($conn, 'sp', 'area_id')) {
        mysqli_query($conn, "ALTER TABLE `sp` ADD COLUMN `area_id` INT NULL AFTER `city_id` ");
        // Try to migrate existing data from 'area' text column
        mysqli_query($conn, "UPDATE `sp` s JOIN `area` a ON s.area = a.area_name SET s.area_id = a.area_id WHERE s.area_id IS NULL");
    }

    if (dp_table_exists($conn, 'user_order')) {
        if (!dp_column_exists($conn, 'user_order', 'base_price')) {
            mysqli_query($conn, "ALTER TABLE `user_order` ADD COLUMN `base_price` DECIMAL(10,2) NULL AFTER `price`");
        }
        if (!dp_column_exists($conn, 'user_order', 'final_price')) {
            mysqli_query($conn, "ALTER TABLE `user_order` ADD COLUMN `final_price` DECIMAL(10,2) NULL AFTER `base_price`");
        }
        if (!dp_column_exists($conn, 'user_order', 'price_breakdown')) {
            mysqli_query($conn, "ALTER TABLE `user_order` ADD COLUMN `price_breakdown` LONGTEXT NULL AFTER `final_price`");
        }
    }
}
