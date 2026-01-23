<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';
$title = 'Wallet Requests';
include 'assets/include/admin_header.php';

// Handle Approval/Rejection
if (isset($_GET['action']) && isset($_GET['id'])) {
    $txn_id = $_GET['id'];
    $action = $_GET['action'];

    // Get Transaction Details
    $txn_sql = "SELECT * FROM wallet_transactions WHERE transaction_id = $txn_id AND status = 'pending'";
    $txn_res = mysqli_query($conn, $txn_sql);

    if (mysqli_num_rows($txn_res) > 0) {
        $txn = mysqli_fetch_assoc($txn_res);
        $sp_id = $txn['sp_id'];
        $amount = $txn['amount'];

        if ($action == 'approve') {
            // Update Transaction Status
            $update_txn = "UPDATE wallet_transactions SET status = 'approved' WHERE transaction_id = $txn_id";
            mysqli_query($conn, $update_txn);

            // Update SP Balance
            $update_sp = "UPDATE sp SET wallet_balance = wallet_balance + $amount WHERE sp_id = $sp_id";
            mysqli_query($conn, $update_sp);

            echo "<script>alert('Transaction Approved!'); window.location.href='wallet_requests.php';</script>";
        } elseif ($action == 'reject') {
            // Update Transaction Status
            $update_txn = "UPDATE wallet_transactions SET status = 'rejected' WHERE transaction_id = $txn_id";
            mysqli_query($conn, $update_txn);

            echo "<script>alert('Transaction Rejected!'); window.location.href='wallet_requests.php';</script>";
        }
    }
}
?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <h5 class="mb-3"><strong>Wallet Recharge Requests</strong></h5>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>SP Name</th>
                                <th>Transaction ID (Manual)</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT wt.*, sp.sp_name, sp.phone 
                                    FROM wallet_transactions wt 
                                    JOIN sp ON wt.sp_id = sp.sp_id 
                                    WHERE wt.status = 'pending' 
                                    ORDER BY wt.created_at DESC";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td>{$row['created_at']}</td>
                                            <td>{$row['sp_name']} ({$row['phone']})</td>
                                            <td>{$row['manual_txn_id']}</td>
                                            <td>{$row['amount']}</td>
                                            <td>
                                                <a href='wallet_requests.php?action=approve&id={$row['transaction_id']}' class='btn btn-success btn-sm'>Approve</a>
                                                <a href='wallet_requests.php?action=reject&id={$row['transaction_id']}' class='btn btn-danger btn-sm'>Reject</a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No pending requests.</td></tr>";
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