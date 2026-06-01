<?php
define('MYSITE', true);
include '../db/dbconnect.php';


$title = 'Main';
$css_directory = '../css/main.min.css';
$css_directory2 = '../css/main.min.css.map';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<body>


    <div class="container">
        <?php
        if (isset($_SESSION['cancel_success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> ' . htmlspecialchars($_SESSION['cancel_success']) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            unset($_SESSION['cancel_success']);
        }
        if (isset($_SESSION['cancel_error'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong> ' . htmlspecialchars($_SESSION['cancel_error']) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            unset($_SESSION['cancel_error']);
        }
        if (isset($_SESSION['review_success'])) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> ' . htmlspecialchars($_SESSION['review_success']) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            unset($_SESSION['review_success']);
        }
        if (isset($_SESSION['review_error'])) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error! </strong> ' . htmlspecialchars($_SESSION['review_error']) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            unset($_SESSION['review_error']);
        }
        ?>
        <br>
        <br>



        <?php
        $customer_id = $_SESSION['customer_id'];
        $query1 = "SELECT * FROM `order_master` WHERE `customer_id` = $customer_id ORDER BY order_id DESC";
        $result1 = mysqli_query($conn, $query1);
        if ($result1) {
            while ($row1 = mysqli_fetch_assoc($result1)) {
                $order_id = $row1['order_id'];
                $full_name = $row1['full_name'];
                $delivery_address = $row1['address'];
                $pay_mode = $row1['pay_mode'];
                $total = $row1['total'];
                $order_date = $row1['order_date'];
                $due_date = $row1['due_date'];
                $estimated_date = date('j F, Y g:i A', strtotime($due_date));
                $real_order_date = date('j F, Y', strtotime($order_date));
                
                $show_cancel = false;
                $check_active_sql = "SELECT COUNT(*) as active_count FROM `user_order` WHERE `order_id` = $order_id AND (`status` = 'pending' OR `status` = 'inprogress')";
                $check_active_res = mysqli_query($conn, $check_active_sql);
                if ($check_active_res) {
                    $active_row = mysqli_fetch_assoc($check_active_res);
                    if ($active_row['active_count'] > 0) {
                        $show_cancel = true;
                    }
                }
                ?>

                <div class="bg-dark p-5">

                    <div class="table-responsive-sm mt-3 ">
                        <table class="table table-hover table-dark p-5 ">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" colspan="5">Order Confirmation <?php echo $order_id; ?> </th>
                                    <th scope="col" colspan="2">Order Date:</th>
                                    <th scope="col" colspan="2"><?php echo $real_order_date; ?> </th>
                                </tr>
                                <tr>
                                    <th scope="col">Sno. </th>
                                    <th scope="col">Service name</th>
                                    <th scope="col">Service prvider name</th>
                                    <th scope="col">Phone(SP)</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Qty.</th>
                                    <th scope="col">Price(Rs.)</th>
                                    <th scope="col">Total(Rs.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 0;
                                $query2 = "SELECT * FROM `user_order` WHERE `order_id` = $order_id";
                                $result2 = mysqli_query($conn, $query2);
                                if ($result2) {
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        $service_title = $row2['service_title'];
                                        $price = $row2['price'];
                                        $qty = $row2['qty'];
                                        $status = $row2['status'];
                                        $sp_id = $row2['sp_id'];
                                        $sno += 1;

                                        $spname = "SELECT * FROM `sp` WHERE sp_id = $sp_id";
                                        $spname_result = mysqli_query($conn, $spname);
                                        while ($sprow = mysqli_fetch_assoc($spname_result)) {
                                            $sp_name = $sprow['sp_name'];
                                            $phone = $sprow['phone'];
                                        }

                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $sno ?></th>
                                            <td><?php echo $service_title ?></td>
                                            <td class="align-middle"><?php echo $sp_name ?></td>
                                            <td><?php echo $phone ?></td>
                                            <td class="align-middle">
                                                <?php
                                                if ($status == 'pending') {
                                                    echo '<span class="badge badge-warning">Pending</span>';
                                                }
                                                if ($status == 'rejected') {
                                                    echo '<span class="badge badge-danger">Rejected</span>';
                                                }
                                                if ($status == 'inprogress') {
                                                    echo '<span class="badge badge-primary">In Progress</span>';
                                                }
                                                if ($status == 'completed') {
                                                    echo '<span class="badge badge-success">Completed</span>';
                                                }
                                                if ($status == 'uncompleted') {
                                                    echo '<span class="badge badge-secondary">Uncompleted</span>';
                                                }
                                                if ($status == 'cancelled') {
                                                    echo '<span class="badge badge-danger">Cancelled by Customer</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $qty ?></td>
                                            <td><?php echo $price ?></td>
                                            <td><?php echo $price * $qty ?></td>
                                        </tr>


                                        <?php
                                    } //while row2 end
                                } // if result 2 end
                        
                                ?>
                            </tbody>
                            <!-- total amount -->
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="4">
                                    <h3>TOTAL</h3>
                                </th>
                                <td>
                                    <h3>Rs. <?php echo $total ?></h3>
                                </td>
                            </tr>
                            <!-- delivery address -->
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="4">Delivery Address</th>
                                <td><?php echo $delivery_address ?></td>
                            </tr>
                            <!-- Estimate date -->
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="4">Estimated Delivery Date</th>
                                <td><?php echo $estimated_date ?></td>
                            </tr>
                            <tr>
                                <th colspan="7"></th>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap">
                                        <form action="../php/invoice.php" method="post" class="mr-2" style="margin-bottom:0;">
                                            <button type="submit" name="invoice" class="btn btn-success">Invoice</button>
                                            <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                                            <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>">
                                        </form>
                                         <?php if ($show_cancel) { ?>
                                         <form action="cancel_order.php" method="post" class="mr-2" style="margin-bottom:0;" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                             <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                                             <button type="submit" name="cancel_order" class="btn btn-danger">Cancel Order</button>
                                         </form>
                                         <?php } ?>
                                         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#reviewModal<?php echo $order_id ?>">Write Review</button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Review Modal -->
                            <div class="modal fade" id="reviewModal<?php echo $order_id ?>" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="reviewModalLabel">Write Review</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="../php/submit_review.php" method="POST">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="rating<?php echo $order_id ?>">Rating</label>
                                                    <select class="form-control" id="rating<?php echo $order_id ?>" name="rating" required>
                                                        <option value="">Select Rating</option>
                                                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                                        <option value="4">⭐⭐⭐⭐ Good</option>
                                                        <option value="3">⭐⭐⭐ Average</option>
                                                        <option value="2">⭐⭐ Poor</option>
                                                        <option value="1">⭐ Very Poor</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="review<?php echo $order_id ?>">Review</label>
                                                    <textarea class="form-control" id="review<?php echo $order_id ?>" name="review_text" rows="4" placeholder="Write your review..." required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit Review</button>
                                            </div>
                                            <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                                            <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Review Modal End -->
                        </table>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <?php
            } //while result1 end
        } //if result1 end
        
        ?>

    </div>





















    <?php
    include '../includes/footer.php';
    // include 'includes/navfooter.php';
    ?>