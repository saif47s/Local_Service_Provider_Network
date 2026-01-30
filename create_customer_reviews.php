<?php
include 'DataBase/dbconnect.php';

$sql = "CREATE TABLE IF NOT EXISTS `customer_reviews` (
    `review_id` INT(11) NOT NULL AUTO_INCREMENT,
    `sp_id` INT(11) NOT NULL,
    `customer_id` INT(11) NOT NULL,
    `order_id` INT(11) NOT NULL,
    `rating` INT(1) NOT NULL,
    `review_text` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `is_read` BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (`review_id`),
    FOREIGN KEY (`sp_id`) REFERENCES sp(`sp_id`) ON DELETE CASCADE,
    FOREIGN KEY (`customer_id`) REFERENCES customer(`customer_id`) ON DELETE CASCADE
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'customer_reviews' created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>