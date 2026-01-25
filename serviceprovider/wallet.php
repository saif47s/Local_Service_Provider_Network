<?php
define('MYSITE', true);
include '../DataBase/dbconnect.php';
$title = 'My Wallet';
include 'assets/include/sp_header.php';
$sp_id = $_SESSION['sp_id'];

// Handle Add Money Request
$msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_money'])) {
    $amount = $_POST['amount'];
    $txn_id = $_POST['txn_id'];

    // Insert into wallet_transactions
    $sql = "INSERT INTO `wallet_transactions` (`sp_id`, `amount`, `type`, `status`, `manual_txn_id`) VALUES ('$sp_id', '$amount', 'credit', 'pending', '$txn_id')";
    if (mysqli_query($conn, $sql)) {
        $msg = '<div class="alert alert-success">Recharge request submitted successfully! Please wait for Admin approval.</div>';
    } else {
        $msg = '<div class="alert alert-danger">Error: ' . mysqli_error($conn) . '</div>';
    }
}

// Fetch Current Balance
$balance_sql = "SELECT wallet_balance FROM sp WHERE sp_id = $sp_id";
$balance_res = mysqli_query($conn, $balance_sql);
$balance_row = mysqli_fetch_assoc($balance_res);
$current_balance = $balance_row['wallet_balance'];

?>

<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <h5 class="mb-3"><strong>My Wallet</strong></h5>

    <?php echo $msg; ?>

    <div class="row">
        <!-- Balance Card -->
        <div class="col-md-4">
            <div class="card shadow text-white bg-theme mb-3">
                <div class="card-body">
                    <h5 class="card-title">Current Balance</h5>
                    <h2 class="card-text">Rs.
                        <?php echo $current_balance; ?>
                    </h2>
                </div>
            </div>
        </div>

        <!-- Add Money Form -->
        <div class="col-md-8">
            <div class="card shadow mb-3">
                <div class="card-header bg-white">
                    <strong>Add Money to Wallet</strong>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                            <label>Amount (PKR)</label>
                            <input type="number" name="amount" class="form-control" required min="1">
                        </div>
                        <div class="form-group">
                            <label>Easypaisa/JazzCash Transaction ID</label>
                            <input type="text" name="txn_id" class="form-control"
                                placeholder="Enter Trx ID sent via SMS" required>
                        </div>
                        <button type="submit" name="add_money" class="btn btn-theme text-white">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <strong>Transaction History</strong>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Transaction ID</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $hist_sql = "SELECT * FROM wallet_transactions WHERE sp_id = $sp_id ORDER BY created_at DESC";
                                $hist_res = mysqli_query($conn, $hist_sql);
                                if (mysqli_num_rows($hist_res) > 0) {
                                    while ($row = mysqli_fetch_assoc($hist_res)) {
                                        $status_badge = '';
                                        if ($row['status'] == 'approved')
                                            $status_badge = '<span class="badge badge-success">Approved</span>';
                                        elseif ($row['status'] == 'pending')
                                            $status_badge = '<span class="badge badge-warning">Pending</span>';
                                        else
                                            $status_badge = '<span class="badge badge-danger">Rejected</span>';

                                        echo "<tr>
                                                <td>{$row['created_at']}</td>
                                                <td>{$row['manual_txn_id']}</td>
                                                <td>" . ucfirst($row['type']) . "</td>
                                                <td>Rs. {$row['amount']}</td>
                                                <td>{$status_badge}</td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No transactions found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'assets/include/sp_footer.php'; ?>