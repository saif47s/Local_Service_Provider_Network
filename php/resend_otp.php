<?php
session_start();
// Include DB and Mailer
include '../DataBase/dbconnect.php';
include 'send_otp.php';

header('Content-Type: application/json');

if (!isset($_SESSION['temp_login_id']) || !isset($_SESSION['temp_email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please signup again.', 'debug' => $_SESSION]);
    exit;
}

$login_id = $_SESSION['temp_login_id'];
$email = $_SESSION['temp_email'];
$new_otp = rand(100000, 999999);

// Update DB
$sql = "UPDATE login SET verification_code = '$new_otp' WHERE login_id = '$login_id'";
if (mysqli_query($conn, $sql)) {
    // Send Email
    if (sendOTP($email, $new_otp)) {
        echo json_encode(['status' => 'success', 'message' => 'New OTP has been sent to ' . $email]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send email. Check SMTP settings.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($conn)]);
}
?>