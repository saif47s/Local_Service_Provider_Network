<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';

if (isset($_GET['review_id'])) {
    $review_id = intval($_GET['review_id']);
    
    $update_query = "UPDATE customer_reviews SET is_read = 1 WHERE review_id = $review_id";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success_msg'] = "Review marked as read.";
    } else {
        $_SESSION['error_msg'] = "Error marking review as read: " . mysqli_error($conn);
    }
    
    header("Location: customer_reviews.php");
    exit();
} else {
    header("Location: customer_reviews.php");
    exit();
}
?>
