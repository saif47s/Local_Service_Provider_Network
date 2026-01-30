<?php
include 'DataBase/dbconnect.php';

$sql = "CREATE TABLE IF NOT EXISTS `reviews` (
    `review_id` int(11) NOT NULL AUTO_INCREMENT,
    `customer_id` int(5) NOT NULL,
    `sp_id` int(5) NOT NULL,
    `service_id` int(5) NOT NULL,
    `order_id` int(5) NOT NULL,
    `rating` int(1) NOT NULL,
    `comment` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`review_id`),
    KEY `customer_id` (`customer_id`),
    KEY `sp_id` (`sp_id`),
    KEY `service_id` (`service_id`),
    CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
    CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`sp_id`) REFERENCES `sp` (`sp_id`),
    CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sql)) {
    echo "Table 'reviews' created successfully.";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}
?>