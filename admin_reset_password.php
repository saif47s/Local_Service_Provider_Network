<?php
session_start();
include 'DataBase/dbconnect.php';
// Include mail sender
include 'php/send_email.php';

$showAlert = false;
$showError = false;

// Step 1: Request OTP
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_otp'])) {
    $username = $_POST["username"];

    // Check if username is admin
    $role_sql = "SELECT role_id FROM role WHERE role_name='admin'";
    $role_result = mysqli_query($conn, $role_sql);
    $role_row = mysqli_fetch_assoc($role_result);
    $admin_role_id = $role_row['role_id'];

    $sql = "SELECT * FROM `login` WHERE username='$username' AND role_id='$admin_role_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];

        if (!empty($email)) {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Save OTP to DB
            $update_otp = "UPDATE `login` SET `otp`='$otp' WHERE username='$username'";
            if (mysqli_query($conn, $update_otp)) {
                // Send Email
                $subject = "Admin Password Reset OTP";
                $body = "Your OTP for Admin Password Reset is: <b>$otp</b>";

                if (sendEmail($email, $subject, $body)) {
                    $showAlert = "OTP sent to registered email: " . $email;
                    $_SESSION['reset_username'] = $username; // Store for next step
                } else {
                    $showError = "Failed to send email. Check SMTP settings.";
                }
            } else {
                $showError = "Database error saving OTP.";
            }
        } else {
            $showError = "No email address found for this admin.";
        }
    } else {
        $showError = "Invalid Admin Username.";
    }
}

// Step 2: Verify OTP & Reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $otp_input = $_POST["otp"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $username = $_SESSION['reset_username'];

    if ($new_password === $confirm_password) {
        // Verify OTP
        $sql = "SELECT * FROM `login` WHERE username='$username' AND otp='$otp_input'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            // Update Password & Clear OTP
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE `login` SET `password`='$new_hash', `otp`=NULL WHERE username='$username'";

            if (mysqli_query($conn, $update_sql)) {
                $showAlert = "Password reset successfully! Redirecting to login...";
                unset($_SESSION['reset_username']);
                echo "<script>
                    setTimeout(function(){
                       window.location.href = 'login.php';
                    }, 3000);
                </script>";
            } else {
                $showError = "Error updating password.";
            }

        } else {
            $showError = "Invalid or expired OTP.";
        }
    } else {
        $showError = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Bootstrap CSS-->
    <link rel="stylesheet" href="serviceprovider/assets/css/bootstrap.min.css">
    <!--Custom style.css-->
    <link rel="stylesheet" href="serviceprovider/assets/css/quicksand.css">
    <link rel="stylesheet" href="serviceprovider/assets/css/style.css">
    <title>Admin Password Reset (OTP)</title>
</head>

<body class="login-body">
    <div class="container-fluid login-wrapper">
        <div class="login-box">
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

            <div class="row h-100 justify-content-center align-items-center ">
                <div class="col-md-6 col-sm-10 col-12 login-box-form p-4">
                    <h3 class="mb-2">Admin Security Reset</h3>
                    <small class="text-muted bc-description">Reset pssword via Email OTP.</small>

                    <?php if (!isset($_SESSION['reset_username'])): ?>
                        <!-- Step 1 Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mt-2">
                            <div class="form-group">
                                <label>Admin Username</label>
                                <input type="text" class="form-control" name="username" required
                                    placeholder="Enter Admin Username">
                            </div>
                            <button type="submit" name="request_otp" class="btn btn-theme btn-block">Send OTP</button>
                        </form>

                    <?php else: ?>
                        <!-- Step 2 Form -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mt-2">
                            <div class="form-group">
                                <label>Enter OTP</label>
                                <input type="text" class="form-control" name="otp" required placeholder="Check your email">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="new_password" required
                                    placeholder="New Password">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password" required
                                    placeholder="Confirm New Password">
                            </div>
                            <button type="submit" name="reset_password" class="btn btn-theme btn-block">Reset
                                Password</button>
                        </form>
                    <?php endif; ?>

                    <div class="mt-2">
                        <a href="login.php" class="btn btn-light btn-block">Cancel</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="serviceprovider/assets/js/jquery.min.js"></script>
    <script src="serviceprovider/assets/js/bootstrap.min.js"></script>
</body>

</html>