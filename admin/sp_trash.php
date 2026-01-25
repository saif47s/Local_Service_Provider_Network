<?php
include '../DataBase/dbconnect.php';
// session_start();
include 'assets/include/admin_header.php';
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <div class="row ">
        <div class="col-lg-5">
            <h5 class="mb-0"><strong>Deleted Service Providers (Trash)</strong></h5>
            <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> Deleted Service Providers</span>
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
            } elseif (isset($_SESSION['statusfail'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error! </strong> ' . $_SESSION['statusfail'] . '
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
                <a href="sp_view.php" class="btn btn-primary"><i class="fa fa-list"></i> View Active Service
                    Providers</a>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT `sp`.* , `city`.*, `login`.`account_status`, `login`.`activation_request`
                            FROM `sp` 
                            INNER JOIN `city` ON `sp`.city_id=`city`.city_id
                            INNER JOIN `login` ON `sp`.login_id=`login`.login_id
                            WHERE `login`.account_status = 'deleted'";

                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                $sno = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sno = $sno + 1;
                                    $login_id = $row['login_id'];
                                    $sp_id = $row['sp_id'];
                                    $sp_name = $row['sp_name'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];
                                    $city = $row['city_name'];
                                    $req = $row['activation_request'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $sno ?>
                                        </td>
                                        <td>
                                            <?php echo $sp_name ?>
                                            <?php if ($req == 1) {
                                                echo '<span class="badge badge-warning ml-2">Active Request</span>';
                                            } ?>
                                        </td>
                                        <td>
                                            <?php echo $email ?>
                                        </td>
                                        <td>
                                            <?php echo $phone ?>
                                        </td>
                                        <td>
                                            <?php echo $city ?>
                                        </td>
                                        <td>
                                            <a href="sp_restore.php?spid=<?php echo $sp_id; ?>&loginid=<?php echo $login_id; ?>"
                                                onclick="return confirm('Do you want to Restore this Service Provider?');"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-undo"></i> Restore
                                            </a>
                                            <a href="sp_permanent_del.php?spid=<?php echo $sp_id; ?>&loginid=<?php echo $login_id; ?>"
                                                onclick="return confirm('Permanent delete Service Provider. Delete all records of Service Provider.');"
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
                                <th>Action</th>
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
    <!--Popper JS-->
    <script src="assets/js/popper.min.js"></script>
    <!--Bootstrap-->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--Datatable-->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <!--Custom Js Script-->
    <script src="assets/js/custom.js"></script>

    <script>
        $('#example').DataTable();
    </script>
    <?php
    include 'assets/include/admin_footer.php';
    ?>