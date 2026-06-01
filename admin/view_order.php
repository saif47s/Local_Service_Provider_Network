<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';
include 'assets/include/admin_header.php';
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">

    <div class="row">
        <div class="col-lg-5">
            <h5 class="mb-0"><strong>Orders</strong></h5>
            <span class="text-secondary">Dashboard <i class="fa fa-angle-right"></i> View Orders</span>
        </div>
        <div class="col-md-auto col-lg-7">
            <?php
            if (isset($_SESSION['order_msg'])) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong> ' . htmlspecialchars($_SESSION['order_msg']) . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>';
                unset($_SESSION['order_msg']);
            }
            ?>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-12">
            <div class="mt-1 mb-3 p-3 bg-white border shadow-sm">
                <div class="table-responsive">
                    <table id="ordersTable" class="table table-striped table-bordered" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Service</th>
                                <th>Service Provider</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Join order_master + user_order + customer + sp + service
                            $sql = "SELECT 
                                        om.order_id,
                                        om.full_name AS customer_name,
                                        om.phone AS customer_phone,
                                        om.total,
                                        om.order_date,
                                        om.pay_mode,
                                        uo.status AS order_status,
                                        s.service_name,
                                        sp.sp_name
                                    FROM order_master om
                                    LEFT JOIN user_order uo ON om.order_id = uo.order_id
                                    LEFT JOIN service s ON uo.service_id = s.service_id
                                    LEFT JOIN sp ON uo.sp_id = sp.sp_id
                                    GROUP BY om.order_id
                                    ORDER BY om.order_date DESC";

                            $result = mysqli_query($conn, $sql);
                            $sno = 1;
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Status badge
                                    $status = $row['order_status'] ?? 'pending';
                                    $badge = 'secondary';
                                    if ($status == 'completed') $badge = 'success';
                                    elseif ($status == 'inprogress' || $status == 'confirm') $badge = 'primary';
                                    elseif ($status == 'rejected' || $status == 'cancelled') $badge = 'danger';
                                    elseif ($status == 'uncompleted') $badge = 'warning';
                                    elseif ($status == 'pending') $badge = 'secondary';
                                    ?>
                                    <tr>
                                        <td class="align-middle"><?php echo $sno++; ?></td>
                                        <td class="align-middle">
                                            <a href="order_detail.php?order_id=<?php echo $row['order_id']; ?>"
                                               class="btn btn-sm btn-outline-primary font-weight-bold">
                                                #<?php echo $row['order_id']; ?>
                                            </a>
                                        </td>
                                        <td class="align-middle"><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($row['customer_phone']); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($row['service_name'] ?? '—'); ?></td>
                                        <td class="align-middle"><?php echo htmlspecialchars($row['sp_name'] ?? '—'); ?></td>
                                        <td class="align-middle"><strong>Rs. <?php echo number_format($row['total'], 0); ?></strong></td>
                                        <td class="align-middle">
                                            <span class="badge badge-<?php echo $badge; ?> p-2">
                                                <?php echo ucfirst($status); ?>
                                            </span>
                                        </td>
                                        <td class="align-middle"><?php echo date('d M Y, h:i A', strtotime($row['order_date'])); ?></td>
                                        <td class="align-middle">
                                            <a href="order_detail.php?order_id=<?php echo $row['order_id']; ?>"
                                               class="btn btn-sm btn-info text-white">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo '<tr><td colspan="10" class="text-center text-muted">No orders found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Page JavaScript Files-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/custom.js"></script>

    <script>
        $(document).ready(function () {
            $('#ordersTable').DataTable({
                "order": [[8, "desc"]],
                "pageLength": 15
            });
        });
    </script>

<?php include 'assets/include/admin_footer.php'; ?>