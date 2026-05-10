<?php
include '../DataBase/dbconnect.php';
include 'assets/include/admin_header.php';

// Fetch admin details
$sql = "SELECT * FROM login WHERE role_id = 1 LIMIT 1";
$result = mysqli_query($conn, $sql);
$admin = mysqli_fetch_assoc($result);

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify old password
    if (password_verify($old_password, $admin['password'])) {
        $update_parts = [];
        $params = [];
        $types = "";

        // Email update
        $update_parts[] = "email = ?";
        $params[] = $email;
        $types .= "s";

        // Password update (if provided)
        if (!empty($new_password)) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_parts[] = "password = ?";
                $params[] = $hashed_password;
                $types .= "s";
            } else {
                $message = '<div class="alert alert-danger">New passwords do not match.</div>';
            }
        }

        if (empty($message)) {
            $update_sql = "UPDATE login SET " . implode(", ", $update_parts) . " WHERE role_id = 1";
            $stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            
            if (mysqli_stmt_execute($stmt)) {
                $message = '<div class="alert alert-success">Profile updated successfully.</div>';
                // Refresh admin data
                $result = mysqli_query($conn, $sql);
                $admin = mysqli_fetch_assoc($result);
            } else {
                $message = '<div class="alert alert-danger">Failed to update profile.</div>';
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $message = '<div class="alert alert-danger">Incorrect old password.</div>';
    }
}
?>

<!--Content right-->
<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <h5 class="mb-3"><strong>Admin Profile</strong></h5>
    
    <?php echo $message; ?>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fa fa-user-edit mr-2 text-theme"></i>Edit Profile Details</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label class="text-muted">Username</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($admin['username'] ?? ''); ?>" readonly>
                            <small class="form-text text-muted">Username cannot be changed.</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($admin['email'] ?? ''); ?>" required>
                        </div>

                        <hr class="my-4">
                        <h6 class="mb-3 text-theme">Change Password (Optional)</h6>
                        <p class="small text-muted mb-3">Leave new password fields blank if you only want to update your email.</p>

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="new_password" placeholder="Enter new password">
                        </div>
                        <div class="form-group">
                            <label>Confirm New Password</label>
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password">
                        </div>

                        <hr class="my-4">
                        <div class="form-group bg-light p-3 rounded">
                            <label class="font-weight-bold">Verify Old Password</label>
                            <input type="password" class="form-control" name="old_password" placeholder="Enter current password to save changes" required>
                            <small class="form-text text-danger">Required to authorize any changes.</small>
                        </div>

                        <div class="text-right mt-4">
                            <button type="submit" name="update_profile" class="btn btn-theme text-white px-4">
                                <i class="fa fa-save mr-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php
include 'assets/include/admin_footer.php';
?>
