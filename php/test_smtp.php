<?php
// php/test_smtp.php

// Adjust path to point to the manual PHPMailer includes
// send_otp.php uses: __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/PHPMailer.php';
// So valid relative path from here is same.

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/SMTP.php';

// EDIT THESE WITH YOUR CREDENTIALS TO TEST
$test_email = 'your_email@gmail.com'; // SENDER EMAIL
$test_password = 'your_app_password'; // APP PASSWORD (NOT GMAIL PASSWORD)
$recipient_email = 'your_email@gmail.com'; // SEND TO YOURSELF

echo "<h1>SMTP Email Test</h1>";

if ($test_email == 'your_email@gmail.com' || $test_password == 'your_app_password') {
    echo "<div style='color:red; font-weight:bold; border:2px solid red; padding:10px;'>
            ERROR: You have not edited this file with your credentials yet!<br>
            Please open <code>php/test_smtp.php</code> and enter your Email and App Password in lines 16-17.
          </div>";
    die();
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host = 'smtp.gmail.com';                       // Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   // Enable SMTP authentication
    $mail->Username = $test_email;
    $mail->Password = $test_password;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            // Enable implicit TLS encryption
    $mail->Port = 587;                                    // TCP port to connect to

    // Recipients
    $mail->setFrom($test_email, 'Test Mailer');
    $mail->addAddress($recipient_email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Test Email from Localhost';
    $mail->Body = '<b>Success!</b> Your SMTP settings are working perfectly.';

    $mail->send();
    echo "<br><hr><h2 style='color:green'>Message has been sent successfully!</h2>";
    echo "<p>Now you can copy these credentials to <code>php/send_otp.php</code>.</p>";

} catch (Exception $e) {
    echo "<br><hr><h2 style='color:red'>Message could not be sent.</h2>";
    echo "<strong>Mailer Error:</strong> {$mail->ErrorInfo}";
}
?>