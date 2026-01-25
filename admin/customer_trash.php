<?php
include '../DataBase/dbconnect.php';
// session_start();
include 'assets/include/admin_header.php';
?>



<div class="col-sm-9 col-xs-12 content pt-3 pl-0">


    <div class="row ">
        <div class="col-lg-5">

            <h5 class="mb-0"><strong>Deleted Customers (Trash)</strong></h5>
            <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Deleted Customers</span>
        </div>
        <div class="col-md-auto col-lg-7">

            <!-- Message section -->
            <?php
            //Alert OR Error Message:
            if (isset($_SESSION['status'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> ' . $_SESSION['status'] . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                unset($_SESSION['status']);
            } elseif (isset($_SESSION['statusfail'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> ' . $_SESSION['statusfail'] . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                unset($_SESSION['statusfail']);
            }
            ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="text-right mb-3">
                <a href="customer_view.php" class="btn btn-primary"><i class="fa fa-list"></i> View Active Customers</a>
            </div>
            <!--Datatable-->
            <div class="mt-1 mb-3 p-3 button-container bg-white border shadow-sm">

                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php // CUSTOMER TRASH CODE.
                            $sql = "SELECT `customer`.* , `city`.*, `login`.`account_status`, `login`.`activation_request`
                            FROM `customer` 
                            INNER JOIN `city` ON `customer`.city_id=`city`.city_id
                            INNER JOIN `login` ON `customer`.login_id=`login`.login_id
                            WHERE `login`.account_status = 'deleted'";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                $sno = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sno = $sno + 1;
                                    $login_id = $row['login_id'];
                                    $customer_id = $row['customer_id'];
                                    $first_name = $row['first_name'];
                                    $last_name = $row['last_name'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];
                                    $city = $row['city_name'];
                                    $address = $row['address'];
                                    $pincode = $row['pincode'];
                                    $req = $row['activation_request'];

                                    ?>
                                    <tr>
                                        <td><?php echo $sno ?></td>
                                        <td>
                                            <?php echo $first_name . " " . $last_name ?>
                                            <?php if($req == 1) { echo '<span class="badge badge-warning ml-2">Active Request</span>'; } ?>
                                        </td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $phone ?></td>
                                        <td><?php echo $city ?></td>
                                        <td><?php echo $address ?></td>
                                        <td><?php echo $pincode ?></td>
                                        <td>
                                            <a href="customer_restore.php?id=<?php echo $login_id; ?>"
                                                onclick="return confirm('Do you want to Restore this customer?');"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-undo"></i> Restore
                                            </a>
                                            <a href="customer_permanent_del.php?id=<?php echo $login_id; ?>"
                                                onclick="return confirm('Permanent delete customer. Delete all records of customer.');"
                                                class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Pincode</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!--/Datatable-->


            <!-- try-start-jsgrid BASIC SCENARIO-->
            <!-- <div class="row mt-3">
                <div class="col-sm-12">
    
                    <div class="mt-1 mb-4 p-3 button-container bg-white border shadow-sm">
                        <h6 class="mb-2">Basic Scenario</h6>

                        <div id="jsGrid"></div>
                    </div>
                 

                </div>
            </div> -->
            <!-- try-end-jsgrid BASIC SCENARIO -->


        </div>
    </div>






    <!-- Page JavaScript Files-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <!--Popper JS-->
    <script src="assets/js/popper.min.js"></script>
    <!--Bootstrap-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--Sweet alert JS-->
    <script src="assets/js/sweetalert.js"></script>
    <!--Progressbar JS-->
    <script src="assets/js/progressbar.min.js"></script>
    <!--Charts-->
    <!--Canvas JS-->
    <script src="assets/js/charts/canvas.min.js"></script>
    <!--Bootstrap Calendar JS-->
    <script src="assets/js/calendar/bootstrap_calendar.js"></script>
    <script src="assets/js/calendar/demo.js"></script>
    <!--Bootstrap Calendar-->
    <!--Datatable-->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <!--JsGrid table-->
    <script src="assets/js/jsgrid.min.js"></script>
    <script src="assets/js/jsgrid-demo.php"></script>

    <!--Custom Js Script-->
    <script src="assets/js/custom.js"></script>
    <!--Custom Js Script-->

    <script>
        $('#example').DataTable();
    </script>
    <?php
    include 'assets/include/admin_footer.php';
    ?>