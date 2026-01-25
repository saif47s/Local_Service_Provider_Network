<?php
include 'DataBase/dbconnect.php';

$title = "Email Verification";
$message = "";
$status = ""; // success or danger

if (isset($_GET['token'])) {
    $token = $_GET['token']; // Get token from URL

    // Validate token exists and account is not verified yet
    $sql = "SELECT * FROM login WHERE verification_code = '$token'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['is_verified'] == 0) {
            // Verify account
            $update = "UPDATE login SET is_verified = 1 WHERE verification_code = '$token'";
            if (mysqli_query($conn, $update)) {
                $status = "success";
                $message = "Your email has been successfully verified! You can now <a href='login.php' class='alert-link'>Login</a>.";
            } else {
                $status = "danger";
                $message = "Something went wrong during verification. Please try again later.";
            }
        } else {
            $status = "info";
            $message = "Your account is already verified. Please <a href='login.php' class='alert-link'>Login</a>.";
        }
    } else {
        $status = "danger";
        $message = "Invalid or Expired Link!";
    }
} else {
    $status = "danger";
    $message = "No token provided!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(-145deg, #f5faff, #87b0de);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .card-header {
            border-radius: 15px 15px 0 0 !important;
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <div
                        class="card-header <?php echo ($status == 'success') ? 'bg-success text-white' : (($status == 'info') ? 'bg-info text-white' : 'bg-danger text-white'); ?>">
                        <?php echo ($status == 'success') ? 'Verification Successful' : 'Verification Failed'; ?>
                    </div>
                    <div class="card-body py-5">
                        <h4 class="card-title text-<?php echo $status; ?>">
                            <?php
                            if ($status == 'success')
                                echo '<i class="fas fa-check-circle display-4"></i>';
                            else
                                echo '<i class="fas fa-exclamation-triangle display-4"></i>';
                            ?>
                        </h4>
                        <p class="card-text mt-3" style="font-size: 1.1em;">
                            <?php echo $message; ?>
                        </p>
                        <a href="login.php" class="btn btn-outline-primary mt-3">Go to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>