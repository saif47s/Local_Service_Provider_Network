<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] != true) {
    header('Location: index.php');
    exit;
}

// Mark reviews as seen when admin opens this page
if (dp_table_exists($conn, 'platform_reviews') && dp_column_exists($conn, 'platform_reviews', 'is_read')) {
    mysqli_query($conn, "UPDATE `platform_reviews` SET `is_read` = 1 WHERE `is_read` = 0");
}

$title = 'Customer Reviews';
include 'assets/include/admin_header.php';
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <div class="row">
        <div class="col-lg-8">
            <h5 class="mb-0"><strong>Customer Reviews</strong></h5>
            <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Platform reviews</span>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT pr.*, c.first_name, c.last_name, c.email
                                FROM platform_reviews pr
                                INNER JOIN customer c ON pr.customer_id = c.customer_id
                                ORDER BY pr.created_at DESC";
                            $result = mysqli_query($conn, $sql);
                            $sno = 0;
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sno++;
                                    $name = trim($row['first_name'] . ' ' . $row['last_name']);
                                    echo '<tr>
                                        <td>' . $sno . '</td>
                                        <td>' . htmlspecialchars($name) . '</td>
                                        <td>' . htmlspecialchars($row['email']) . '</td>
                                        <td><span class="badge badge-warning">' . (int) $row['rating'] . ' ★</span></td>
                                        <td>' . nl2br(htmlspecialchars($row['review_text'])) . '</td>
                                        <td>' . htmlspecialchars($row['created_at']) . '</td>
                                    </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center text-muted">No customer reviews yet.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/include/admin_footer.php'; ?>
