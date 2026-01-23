<?php
include '../DataBase/dbconnect.php';
include 'assets/include/admin_header.php';
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <div class="row ">
        <div class="col-lg-5">
            <h5 class="mb-0"><strong>Revenue Report</strong></h5>
            <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Revenue Details</span>
        </div>
        <div class="col-md-auto col-lg-7">
            <!-- Message section -->
            <?php
            if (isset($_SESSION['status'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> ' . $_SESSION['status'] . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                unset($_SESSION['status']);
            }
            ?>
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
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Service Provider(s)</th>
                                <th>Services</th>
                                <th>Total Amount</th>
                                <th class="bg-success text-white">Revenue (Commission)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch Orders with Commission, joined with SP names
                            $sql = "SELECT om.order_id, om.order_date, om.full_name, om.total, om.commission, 
                                           GROUP_CONCAT(DISTINCT sp.sp_name SEPARATOR ', ') as sp_names,
                                           GROUP_CONCAT(DISTINCT uo.service_title SEPARATOR ', ') as service_titles
                                    FROM order_master om
                                    JOIN user_order uo ON om.order_id = uo.order_id
                                    JOIN sp ON uo.sp_id = sp.sp_id
                                    GROUP BY om.order_id
                                    ORDER BY om.order_date DESC";

                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $order_id = $row['order_id'];
                                    $date = date('d M Y', strtotime($row['order_date']));
                                    $customer = $row['full_name'];
                                    $sp_names = $row['sp_names'];
                                    $services = $row['service_titles'];
                                    $total = $row['total'];
                                    $commission = $row['commission'];
                                    ?>
                                    <tr>
                                        <td>#
                                            <?php echo $order_id ?>
                                        </td>
                                        <td>
                                            <?php echo $date ?>
                                        </td>
                                        <td>
                                            <?php echo $customer ?>
                                        </td>
                                        <td>
                                            <?php echo $sp_names ?>
                                        </td>
                                        <td>
                                            <?php echo $services ?>
                                        </td>
                                        <td>Rs.
                                            <?php echo $total ?>
                                        </td>
                                        <td class="font-weight-bold text-success">Rs.
                                            <?php echo $commission ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Service Provider(s)</th>
                                <th>Services</th>
                                <th>Total Amount</th>
                                <th>Revenue</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!--/Datatable-->
        </div>
    </div>

    <!-- Page JavaScript Files-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert.js"></script>
    <script src="assets/js/progressbar.min.js"></script>
    <script src="assets/js/charts/canvas.min.js"></script>
    <script src="assets/js/calendar/bootstrap_calendar.js"></script>
    <script src="assets/js/calendar/demo.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        $('#example').DataTable({
            "order": [[0, "desc"]]
        });
    </script>

    <?php include 'assets/include/admin_footer.php'; ?>
    <!-- footer end -->