<?php
include '../DataBase/dbconnect.php';
$title = 'Review Customer';
include 'assets/include/sp_header.php';

// Enable Error Reporting for Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    echo "<script>window.location.href = '../login.php';</script>";
    exit;
}

$sp_id = $_SESSION['sp_id'];
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    $order_id = $_POST['order_id'];
    $customer_id = $_POST['customer_id'];
    $rating = $_POST['rating'];
    $review_text = mysqli_real_escape_string($conn, $_POST['review_text']);

    $sql = "INSERT INTO `customer_reviews` (`sp_id`, `customer_id`, `order_id`, `rating`, `review_text`) VALUES ('$sp_id', '$customer_id', '$order_id', '$rating', '$review_text')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['status_done'] = "Submitted";
        echo '<script type="text/javascript">
            window.location.href="order_details.php?order_id=' . $order_id . '&sp_id=' . $sp_id . '";
        </script>';
    } else {
        $msg = '<div class="alert alert-danger">Database Error: ' . mysqli_error($conn) . '</div>';
    }
}
// Debugging Input
/*
echo "Order ID: " . $order_id . "<br>";
echo "Customer ID: " . $customer_id . "<br>";
*/
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="mt-4 mb-4 p-3 bg-white border shadow-sm lh-sm">
                <h4>Review Customer</h4>
                <hr>
                <?php echo $msg; ?>
                <form action="" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">

                    <div class="form-group">
                        <label>Rating (1-5)</label>
                        <select name="rating" class="form-control" required>
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Good</option>
                            <option value="3">3 - Average</option>
                            <option value="2">2 - Poor</option>
                            <option value="1">1 - Terrible</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Review</label>
                        <textarea name="review_text" class="form-control" rows="5" required
                            placeholder="Describe your experience with this customer..."></textarea>
                    </div>

                    <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
                    <a href="order_details.php?order_id=<?php echo $order_id; ?>&sp_id=<?php echo $sp_id; ?>"
                        class="btn btn-secondary">Skip / Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/include/sp_footer.php'; ?>