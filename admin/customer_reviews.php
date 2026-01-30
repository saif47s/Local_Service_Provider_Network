<?php
include '../DataBase/dbconnect.php';
// Mark all reviews as read when page is opened
$update_sql = "UPDATE customer_reviews SET is_read = 1 WHERE is_read = 0";
mysqli_query($conn, $update_sql);

include 'assets/include/admin_header.php';
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <div class="row ">
        <div class="col-lg-5">
            <h5 class="mb-0"><strong>Customer Reviews</strong></h5>
            <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Customer Reviews</span>
        </div>
        <div class="col-md-auto col-lg-7">
            <!-- Message section if needed -->
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12">
            <!--Datatable-->
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Review Date</th>
                                <th>Service Provider</th>
                                <th>Customer Name</th>
                                <th>Order ID</th>
                                <th>Rating</th>
                                <th>Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT cr.*, s.sp_name, c.first_name, c.last_name
                                    FROM customer_reviews cr
                                    JOIN sp s ON cr.sp_id = s.sp_id
                                    JOIN customer c ON cr.customer_id = c.customer_id
                                    ORDER BY cr.created_at DESC";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                $sno = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sno++;
                                    $date = date('d-M-Y', strtotime($row['created_at']));
                                    $sp_name = $row['sp_name'];
                                    $customer_name = $row['first_name'] . ' ' . $row['last_name'];
                                    $order_id = $row['order_id'];
                                    $rating = $row['rating'];
                                    $review = $row['review_text'];

                                    // Star Rating Display
                                    $stars = "";
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
                                            $stars .= '<i class="fa fa-star text-warning"></i>';
                                        } else {
                                            $stars .= '<i class="fa fa-star text-secondary"></i>';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $sno ?>
                                        </td>
                                        <td>
                                            <?php echo $date ?>
                                        </td>
                                        <td>
                                            <?php echo $sp_name ?>
                                        </td>
                                        <td>
                                            <?php echo $customer_name ?>
                                        </td>
                                        <td>
                                            <?php echo $order_id ?>
                                        </td>
                                        <td>
                                            <?php echo $stars ?> (
                                            <?php echo $rating ?>)
                                        </td>
                                        <td>
                                            <?php echo $review ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/Datatable-->
        </div>
    </div>

    <!-- Page JavaScript Files-->
    <script>
        $('#example').DataTable();
    </script>
    <?php
    include 'assets/include/admin_footer.php';
    ?>