<?php
define('MYSITE', true);
include '../db/dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : 0;
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $review_text = isset($_POST['review_text']) ? mysqli_real_escape_string($conn, $_POST['review_text']) : '';

    if ($order_id && $customer_id && $rating && $review_text) {
        // Get SP ID from order
        $sp_query = "SELECT sp_id FROM user_order WHERE order_id = $order_id LIMIT 1";
        $sp_result = mysqli_query($conn, $sp_query);
        
        if ($sp_result && mysqli_num_rows($sp_result) > 0) {
            $sp_row = mysqli_fetch_assoc($sp_result);
            $sp_id = $sp_row['sp_id'];
            
            // Check if review already exists
            $check_query = "SELECT review_id FROM customer_reviews WHERE order_id = $order_id AND customer_id = $customer_id";
            $check_result = mysqli_query($conn, $check_query);
            
            if ($check_result && mysqli_num_rows($check_result) === 0) {
                // Insert review
                $insert_query = "INSERT INTO customer_reviews (sp_id, customer_id, order_id, rating, review_text, created_at, is_read) 
                                VALUES ($sp_id, $customer_id, $order_id, $rating, '$review_text', NOW(), 0)";
                
                if (mysqli_query($conn, $insert_query)) {
                    $_SESSION['review_success'] = "Review submitted successfully!";
                    header("Location: ../customer/order_details.php");
                    exit();
                } else {
                    $_SESSION['review_error'] = "Error submitting review: " . mysqli_error($conn);
                    header("Location: ../customer/order_details.php");
                    exit();
                }
            } else {
                $_SESSION['review_error'] = "You have already submitted a review for this order.";
                header("Location: ../customer/order_details.php");
                exit();
            }
        } else {
            $_SESSION['review_error'] = "Invalid order.";
            header("Location: ../customer/order_details.php");
            exit();
        }
    } else {
        $_SESSION['review_error'] = "Please fill in all required fields.";
        header("Location: ../customer/order_details.php");
        exit();
    }
} else {
    header("Location: ../customer/order_details.php");
    exit();
}
?>
