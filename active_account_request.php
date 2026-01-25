<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="serviceprovider/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="serviceprovider/assets/css/style.css">
    <title>Request Account Activation</title>
</head>

<body class="login-body">
    <div class="container-fluid login-wrapper">
        <div class="login-box">
            <?php
            include 'DataBase/dbconnect.php';
            session_start();

            $msg = "";
            $msgType = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $username = $_POST["username"];
                $password = $_POST["password"];

                $sql = "SELECT * FROM `login` WHERE `username`='$username'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    // Verify password
                    if (password_verify($password, $row['password'])) {
                        // Check if deleted
                        if ($row['account_status'] == 'deleted') {
                            // Check if already requested
                            if ($row['activation_request'] == 1) {
                                $msg = "Request already sent! Please wait for Admin approval.";
                                $msgType = "warning";
                            } else {
                                // Update request flag
                                $login_id = $row['login_id'];
                                $update = "UPDATE `login` SET `activation_request` = 1 WHERE `login_id` = '$login_id'";
                                if (mysqli_query($conn, $update)) {
                                    $msg = "Activation request sent to Admin successfully!";
                                    $msgType = "success";
                                } else {
                                    $msg = "Error sending request.";
                                    $msgType = "danger";
                                }
                            }
                        } else {
                            $msg = "This account is Active. You can <a href='login.php'>Login here</a>.";
                            $msgType = "info";
                        }
                    } else {
                        $msg = "Invalid Password.";
                        $msgType = "danger";
                    }
                } else {
                    $msg = "Username not found.";
                    $msgType = "danger";
                }
            }
            ?>

            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-md-6 col-sm-10 col-12 login-box-form p-4">
                    <h3 class="mb-2">Reactivate Account</h3>
                    <small class="text-muted">Enter credentials to request activation</small>

                    <?php if ($msg != ""): ?>
                        <div class="alert alert-<?php echo $msgType; ?> mt-3">
                            <?php echo $msg; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="mt-2">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-theme btn-block p-2 mb-1">Send Request</button>
                            <a href="login.php" class="btn btn-light btn-block">Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>