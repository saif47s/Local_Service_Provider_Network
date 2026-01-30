<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0); // Keep off to prevent breaking JSON/Layout, we catch errors below

define('MYSITE', true);
include '../DataBase/dbconnect.php';
include 'assets/include/admin_header.php';

$showAlert = false;
$showError = false;

try {
    // Fetch current details
    if (!isset($_SESSION['admin_username'])) {
        throw new Exception("Admin not logged in.");
    }

    $admin_username = $_SESSION['admin_username'];

    // Get Role ID safely
    $role_sql = "SELECT role_id FROM role WHERE role_name='admin'";
    $role_result = mysqli_query($conn, $role_sql);
    if (!$role_result || mysqli_num_rows($role_result) == 0) {
        throw new Exception("Admin role not found in database.");
    }
    $role_row = mysqli_fetch_assoc($role_result);
    $admin_role_id = $role_row['role_id'];

    // Get User Details safely
    $sql = "SELECT * FROM `login` WHERE username='$admin_username' AND role_id='$admin_role_id'";
    $result = mysqli_query($conn, $sql);
    if (!$result || mysqli_num_rows($result) == 0) {
        throw new Exception("Admin user '$admin_username' not found in database.");
    }
    $row = mysqli_fetch_assoc($result);

    $current_email = isset($row['email']) ? $row['email'] : '';
    $admin_login_id = $row['login_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_username = mysqli_real_escape_string($conn, $_POST["username"]);
        $new_email = mysqli_real_escape_string($conn, $_POST["email"]);
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];
        $current_password_input = $_POST["current_password"];

        // 1. Verify Current Password
        if (password_verify($current_password_input, $row['password'])) {

            $update_email = false;
            $update_username = false;
            $update_password = false;
            $can_update = true;

            // Check if username changed
            if ($new_username != $admin_username) {
                // Check if already exists
                $check_sql = "SELECT * FROM `login` WHERE username='$new_username' AND login_id != '$admin_login_id'";
                $check_user = mysqli_query($conn, $check_sql);
                if ($check_user && mysqli_num_rows($check_user) > 0) {
                    $showError = "Username '$new_username' is already taken.";
                    $can_update = false;
                } else {
                    $update_username = true;
                }
            }

            // Check if email changed
            if ($new_email != $current_email) {
                $update_email = true;
            }

            // Check if updated password
            if (!empty($new_password)) {
                if ($new_password === $confirm_password) {
                    $update_password = true;
                } else {
                    $showError = "New passwords do not match.";
                    $can_update = false;
                }
            }

            if ($can_update) {
                $update_query_parts = [];
                if ($update_username) {
                    $update_query_parts[] = "`username`='$new_username'";
                }
                if ($update_email) {
                    $update_query_parts[] = "`email`='$new_email'";
                }
                if ($update_password) {
                    $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_query_parts[] = "`password`='$new_hash'";
                }

                if (!empty($update_query_parts)) {
                    $update_sql = "UPDATE `login` SET " . implode(", ", $update_query_parts) . " WHERE login_id='$admin_login_id'";
                    if (mysqli_query($conn, $update_sql)) {
                        $showAlert = "Profile updated successfully!";

                        // Update Session/Local vars if username changed
                        if ($update_username) {
                            $_SESSION['admin_username'] = $new_username;
                            $admin_username = $new_username;
                        }
                        if ($update_email) {
                            $current_email = $new_email;
                        }
                    } else {
                        // Check specifically for missing column error
                        $db_err = mysqli_error($conn);
                        if (strpos($db_err, "Unknown column 'email'") !== false) {
                            throw new Exception("Database mismatch: 'email' column missing. Please run the database update script.");
                        }
                        throw new Exception("Database Error: " . $db_err);
                    }
                } else {
                    $showAlert = "No changes made.";
                }
            }

        } else {
            $showError = "Incorrect current password. Changes not saved.";
        }
    }

} catch (Exception $e) {
    $showError = "Error: " . $e->getMessage();
}
?>

<!--Content right-->
<div class="col-sm-9 col-xs-12 content pt-3 pl-0">
    <h5 class="mb-3"><strong>Admin Profile</strong></h5>

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
                        <label class="control-label col-sm-3" for="username">Username:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" name="username" required
                                value="<?php echo isset($admin_username) ? $admin_username : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3" for="email">Email:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" required
                                value="<?php echo isset($current_email) ? $current_email : ''; ?>">
                        </div>
                    </div>

                    <hr>
                    <p class="text-muted small">Fill fields below ONLY if you want to change your password.</p>

                    <div class="form-group row">
                        <label class="control-label col-sm-3" for="new_password">New Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="Leave blank to keep current password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-3" for="confirm_password">Confirm New Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    <hr>
                    <p class="text-danger small">Required to save ANY changes.</p>
                    <div class="form-group row">
                        <label class="control-label col-sm-3" for="current_password">Current Password:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required placeholder="Enter current password to save changes">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-theme">Save Changes</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Fallback JS to Force Hide Loader if footer fails or hangs -->
<script>
    setTimeout(function () {
        if (typeof $ !== 'undefined') {
            $(".loader-wrapper").fadeOut("fast");
        } else {
            // Native JS fallback
            var loader = document.querySelector('.loader-wrapper');
            if (loader) loader.style.display = 'none';
        }
    }, 1000); // Wait 1 sec then force hide
</script>

<?php include 'assets/include/admin_footer.php'; ?>