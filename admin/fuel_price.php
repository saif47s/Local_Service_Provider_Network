<?php
include '../DataBase/dbconnect.php';
include 'assets/include/admin_header.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_fuel_price'])) {
    $new_price = (float)$_POST['fuel_price'];
    
    $update_sql = "UPDATE settings SET setting_value = ? WHERE setting_key = 'fuel_price'";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "s", $new_price);
    if (mysqli_stmt_execute($stmt)) {
        $message = '<div class="alert alert-success">Fuel price updated successfully.</div>';
    } else {
        $message = '<div class="alert alert-danger">Failed to update fuel price.</div>';
    }
    mysqli_stmt_close($stmt);
}

// Fetch current fuel price
$sql = "SELECT setting_value FROM settings WHERE setting_key = 'fuel_price' LIMIT 1";
$result = mysqli_query($conn, $sql);
$current_price = "7"; // default fallback
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $current_price = $row['setting_value'];
}
?>

<!--Content right-->
<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <h5 class="mb-3"><strong>Manage Fuel Price</strong></h5>
    
    <?php echo $message; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fa fa-gas-pump mr-2 text-theme"></i>Fuel Price Settings</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">This price will be used in the customer's cart to calculate the delivery/fuel charges based on kilometers.</p>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Fuel Price per Kilometer (Rs)</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rs.</span>
                                </div>
                                <input type="number" step="0.1" min="0" class="form-control" name="fuel_price" value="<?php echo htmlspecialchars($current_price); ?>" required>
                            </div>
                        </div>
                        <button type="submit" name="update_fuel_price" class="btn btn-theme text-white"><i class="fa fa-save mr-2"></i>Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include 'assets/include/admin_footer.php';
?>
