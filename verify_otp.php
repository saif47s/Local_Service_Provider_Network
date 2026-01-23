<?php
session_start();
include 'DataBase/dbconnect.php';

$alert = "";
$error = "";

if (!isset($_SESSION['temp_login_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_input = $_POST['otp'];
    $login_id = $_SESSION['temp_login_id'];

    $sql = "SELECT * FROM login WHERE login_id = '$login_id' AND verification_code = '$otp_input'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $update = "UPDATE login SET is_verified = 1 WHERE login_id = '$login_id'";
        if (mysqli_query($conn, $update)) {
            unset($_SESSION['temp_login_id']);
            unset($_SESSION['temp_email']);
            echo "<script>
                alert('Verification Successful! Please Login.');
                window.location.href = 'login.php';
            </script>";
        } else {
            $error = "Database Error!";
        }
    } else {
        $error = "Invalid OTP! Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="serviceprovider/assets/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4>Email Verification</h4>
                    </div>
                    <div class="card-body">
                        <div id="msgBox"></div>
                        <?php if ($error)
                            echo "<div class='alert alert-danger'>$error</div>"; ?>

                        <?php
                        // Debug OTP for Localhost
                        if (isset($_SESSION['temp_login_id'])) {
                            $lid = $_SESSION['temp_login_id'];
                            $q = "SELECT verification_code FROM login WHERE login_id='$lid'";
                            $r = mysqli_query($conn, $q);
                            if ($row = mysqli_fetch_assoc($r)) {
                                echo "<div class='alert alert-warning'>
                                            <strong>Debug OTP (Localhost Only):</strong> " . $row['verification_code'] . "
                                          </div>";
                            }
                        }
                        ?>

                        <p>OTP sent to:
                            <strong><?php echo isset($_SESSION['temp_email']) ? $_SESSION['temp_email'] : 'Email'; ?></strong>
                        </p>

                        <form action="" method="POST">
                            <div class="form-group">
                                <label>Enter 6-Digit OTP</label>
                                <input type="text" name="otp" class="form-control" maxlength="6" required
                                    placeholder="123456" autofocus>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Verify OTP</button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <span id="timer">Wait 60s to resend</span>
                            <br>
                            <button id="resendBtn" class="btn btn-secondary mt-2" disabled>Resend OTP</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let timeLeft = 60;
        const btn = document.getElementById('resendBtn');
        const timerSpan = document.getElementById('timer');

        function updateTimer() {
            if (timeLeft <= 0) {
                btn.disabled = false;
                btn.innerText = "Resend OTP";
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-info');
                timerSpan.innerText = "";
            } else {
                btn.disabled = true;
                btn.innerText = "Resend OTP";
                timerSpan.innerText = "Resend available in " + timeLeft + "s";
                timeLeft--;
                setTimeout(updateTimer, 1000);
            }
        }

        updateTimer();

        btn.addEventListener('click', function () {
            btn.disabled = true;
            btn.innerText = "Sending...";

            $.ajax({
                url: 'php/resend_otp.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        // Reset Timer
                        timeLeft = 60;
                        updateTimer();
                        // Show Success
                        $('#msgBox').html('<div class="alert alert-success">' + response.message + '</div>');
                    } else {
                        btn.disabled = false;
                        btn.innerText = "Resend OTP";
                        $('#msgBox').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function () {
                    btn.disabled = false;
                    btn.innerText = "Resend OTP";
                    $('#msgBox').html('<div class="alert alert-danger">Server Error.</div>');
                }
            });
        });
    </script>
</body>

</html>