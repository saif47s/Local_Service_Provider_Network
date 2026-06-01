<?php
include '../DataBase/dbconnect.php';
$title = 'Rate Customer';
include 'assets/include/sp_header.php';

// get parameters
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$sp_id = isset($_GET['sp_id']) ? (int)$_GET['sp_id'] : 0;
$customer_id = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;

$msg = '';
$msgClass = 'success';

// validation
if ($order_id <= 0 || $sp_id <= 0 || $customer_id <= 0) {
    echo "<script>window.location.href = 'order_view.php';</script>";
    exit;
}

// Fetch customer name for the UI
$cust_sql = "SELECT first_name, last_name FROM customer WHERE customer_id = $customer_id";
$cust_res = mysqli_query($conn, $cust_sql);
$cust_row = mysqli_fetch_assoc($cust_res);
$customer_name = $cust_row ? trim($cust_row['first_name'] . ' ' . $cust_row['last_name']) : 'Customer';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = (int)($_POST['rating'] ?? 0);
    $review_text = trim($_POST['review_text'] ?? '');

    if ($rating < 1 || $rating > 5) {
        $msg = 'Please select a rating from 1 to 5 stars.';
        $msgClass = 'danger';
    } elseif ($review_text === '') {
        $msg = 'Please write your review.';
        $msgClass = 'danger';
    } else {
        $review_text = mysqli_real_escape_string($conn, $review_text);
        
        // check if review already exists
        $check_sql = "SELECT * FROM `sp_reviews` WHERE `order_id` = $order_id AND `sp_id` = $sp_id AND `customer_id` = $customer_id";
        $check_res = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_res) > 0) {
            $msg = 'You have already submitted a review for this customer on this order.';
            $msgClass = 'warning';
        } else {
            $insert = "INSERT INTO `sp_reviews` (`sp_id`, `customer_id`, `order_id`, `rating`, `review_text`)
                       VALUES ('$sp_id', '$customer_id', '$order_id', '$rating', '$review_text')";
            if (mysqli_query($conn, $insert)) {
                $msg = 'Thank you! Your review has been submitted successfully. Redirecting...';
                $msgClass = 'success';
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'order_details.php?order_id=$order_id&sp_id=$sp_id';
                    }, 2000);
                </script>";
            } else {
                $msg = 'Could not save review. Please try again later.';
                $msgClass = 'danger';
            }
        }
    }
}
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <div class="row">
        <div class="col-lg-5">
            <h5 class="mb-0"><strong>Rate Customer</strong></h5>
            <span class="text-secondary">Workspace <i class="fa fa-angle-right"></i> Rate Customer</span>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <?php if ($msg !== '') { ?>
                <div class="alert alert-<?php echo htmlspecialchars($msgClass); ?> alert-dismissible fade show" role="alert">
                    <strong>Notice:</strong> <?php echo htmlspecialchars($msg); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-theme text-white">
                    <strong>Rate customer for Order #<?php echo $order_id; ?></strong>
                </div>
                <div class="card-body bg-white text-dark">
                    <p class="text-muted">Rate your experience with customer: <strong><?php echo htmlspecialchars($customer_name); ?></strong></p>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="rating" class="font-weight-bold">Rating</label>
                            <select name="rating" id="rating" class="form-control" required>
                                <option value="">Select Stars</option>
                                <option value="5">★★★★★ (5 - Excellent)</option>
                                <option value="4">★★★★☆ (4 - Good)</option>
                                <option value="3">★★★☆☆ (3 - Average)</option>
                                <option value="2">★★☆☆☆ (2 - Poor)</option>
                                <option value="1">★☆☆☆☆ (1 - Bad)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="review_text" class="font-weight-bold">Review Comments</label>
                            <textarea name="review_text" id="review_text" class="form-control" rows="5" placeholder="Share your experience working with this customer..." required></textarea>
                        </div>
                        <button type="submit" name="submit_review" class="btn btn-success">Submit Review</button>
                        <a href="order_details.php?order_id=<?php echo $order_id; ?>&sp_id=<?php echo $sp_id; ?>" class="btn btn-outline-secondary ml-2">Skip / Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'assets/include/sp_footer.php';
?>
