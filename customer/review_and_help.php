<?php
define('MYSITE', true);
include '../db/dbconnect.php';

$title = 'Review & Help';
$css_directory = '../css/main.min.css';
$css_directory2 = '../css/main.min.css.map';
include 'includes/header.php';
include 'includes/navbar.php';

$customer_id = (int) ($_SESSION['customer_id'] ?? 0);
$msg = '';
$msgClass = 'success';

$support_email = 'labpc4472@gmail.com';
$support_phone = '03115121472';
$whatsapp_url = 'https://wa.me/923115121472';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $rating = (int) ($_POST['rating'] ?? 0);
    $review_text = trim($_POST['review_text'] ?? '');

    if ($rating < 1 || $rating > 5) {
        $msg = 'Please select a rating from 1 to 5 stars.';
        $msgClass = 'danger';
    } elseif ($review_text === '') {
        $msg = 'Please write your review.';
        $msgClass = 'danger';
    } elseif ($customer_id <= 0) {
        $msg = 'Please login to submit a review.';
        $msgClass = 'warning';
    } else {
        $review_text = mysqli_real_escape_string($conn, $review_text);
        $insert = "INSERT INTO `platform_reviews` (`customer_id`, `rating`, `review_text`)
                   VALUES ('$customer_id', '$rating', '$review_text')";
        if (mysqli_query($conn, $insert)) {
            $msg = 'Thank you! Your review has been submitted successfully.';
            $msgClass = 'success';
        } else {
            $msg = 'Could not save review. Please try again later.';
            $msgClass = 'danger';
        }
    }
}

$my_reviews = [];
if ($customer_id > 0) {
    $history = mysqli_query(
        $conn,
        "SELECT `rating`, `review_text`, `created_at`
         FROM `platform_reviews`
         WHERE `customer_id` = '$customer_id'
         ORDER BY `created_at` DESC
         LIMIT 10"
    );
    if ($history) {
        while ($row = mysqli_fetch_assoc($history)) {
            $my_reviews[] = $row;
        }
    }
}
?>

<div class="container my-5">
    <h3 class="mb-4 text-dark"><i class="fa fa-life-ring"></i> Review &amp; Help</h3>

    <?php if ($msg !== '') { ?>
        <div class="alert alert-<?php echo htmlspecialchars($msgClass); ?> alert-dismissible fade show">
            <?php echo htmlspecialchars($msg); ?>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php } ?>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-c1-1 text-white">
                    <strong>Help &amp; Support</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted">Need help? Contact us anytime.</p>
                    <p class="mb-2">
                        <i class="fa fa-envelope text-primary"></i>
                        <strong>Email:</strong>
                        <a href="mailto:<?php echo htmlspecialchars($support_email); ?>">
                            <?php echo htmlspecialchars($support_email); ?>
                        </a>
                    </p>
                    <p class="mb-3">
                        <i class="fa fa-phone text-success"></i>
                        <strong>Phone / WhatsApp:</strong>
                        <?php echo htmlspecialchars($support_phone); ?>
                    </p>
                    <a href="<?php echo htmlspecialchars($whatsapp_url); ?>" target="_blank" rel="noopener"
                        class="btn btn-success btn-block">
                        <i class="fa fa-whatsapp"></i> Chat on WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-secondary text-white">
                    <strong>Write a Review</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Share your experience with Hyper Local Home Services.</p>
                    <form method="post" action="">
                        <div class="form-group">
                            <label>Your rating</label>
                            <select name="rating" class="form-control" required>
                                <option value="">Select stars</option>
                                <option value="5">★★★★★ (5 - Excellent)</option>
                                <option value="4">★★★★☆ (4 - Good)</option>
                                <option value="3">★★★☆☆ (3 - Average)</option>
                                <option value="2">★★☆☆☆ (2 - Poor)</option>
                                <option value="1">★☆☆☆☆ (1 - Bad)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Your review</label>
                            <textarea name="review_text" class="form-control" rows="4" required
                                placeholder="Tell us about your experience..."></textarea>
                        </div>
                        <button type="submit" name="submit_review" class="btn btn-c1-1">Submit Review</button>
                        <a href="customer_index.php" class="btn btn-outline-secondary ml-2">Back to Home</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (count($my_reviews) > 0) { ?>
        <div class="card shadow-sm border-0 mt-2">
            <div class="card-header"><strong>Your recent reviews</strong></div>
            <ul class="list-group list-group-flush">
                <?php foreach ($my_reviews as $rev) { ?>
                    <li class="list-group-item">
                        <span class="badge badge-warning"><?php echo (int) $rev['rating']; ?> ★</span>
                        <span class="text-muted small ml-2"><?php echo htmlspecialchars($rev['created_at']); ?></span>
                        <p class="mb-0 mt-2"><?php echo nl2br(htmlspecialchars($rev['review_text'])); ?></p>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
</div>

<br><br>

<?php
include '../includes/footer.php';
include 'includes/navfooter.php';
?>
