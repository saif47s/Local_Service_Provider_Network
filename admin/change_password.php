<?php
include '../DataBase/dbconnect.php';
include 'assets/include/admin_header.php';

$showAlert = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST["old_password"];
    $security_answer = $_POST["security_answer"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    $admin_username = $_SESSION['admin_username'];
    $correct_security_answer = "BlueSky786";

    // 1. Verify Security Answer
    if ($security_answer !== $correct_security_answer) {
        $showError = "Incorrect answer to the security question.";
    } elseif ($new_password !== $confirm_password) {
        $showError = "New passwords do not match.";
    } else {
        // 2. Verify Old Password
        $sql = "SELECT * FROM `login` WHERE username='$admin_username' AND role_id=(SELECT role_id FROM role WHERE role_name='admin')";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];

            if (password_verify($old_password, $hashed_password)) {
                // 3. Update Password
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE `login` SET `password`='$new_hashed_password' WHERE username='$admin_username'";

                if (mysqli_query($conn, $update_sql)) {
                    $showAlert = "Password changed successfully! Please login again.";
                    session_destroy(); // Force re-login
                    echo "<script>
                        setTimeout(function(){
                           window.location.href = '../login.php';
                        }, 2000);
                    </script>";
                } else {
                    $showError = "Error updating password: " . mysqli_error($conn);
                }
            } else {
                $showError = "Incorrect old password.";
            }
        } else {
            $showError = "Admin account not found.";
        }
    }
}
?>

<!--Content right-->
<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <h5 class="mb-3"><strong>Change Password</strong></h5>

    <div class="row">
        <div class="col-sm-12">
            <div class="mt-4 mb-3 p-3 button-container bg-white border shadow-sm">

                <?php
                if ($showAlert) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success! </strong> ' . $showAlert . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                }
                if ($showError) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong> ' . $showError . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                }
                ?>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

                    <div class="form-group row">
                        <label class="control-label col-sm-3" for="old_password">Old Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="old_password" name="old_password" required
                                placeholder="Enter current password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3">Security Question:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="What was the name of your first stuffed toy?"
                                readonly style="background-color: #f8f9fa;">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3" for="security_answer">Security Answer:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="security_answer" name="security_answer" required
                                placeholder="Enter answer">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3" for="new_password">New Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="new_password" name="new_password" required
                                placeholder="Enter new password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3" for="confirm_password">Confirm New Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                required placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-theme">Change Password</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'assets/include/admin_footer.php'; ?>