<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Adjust path as needed
require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/SMTP.php';

function sendOTP($toEmail, $otp)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'your_email@gmail.com';                     //SMTP username (REPLACE THIS)
        $mail->Password = 'your_app_password';                               //SMTP password (REPLACE THIS)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('no-reply@hyperlocal.com', 'Hyper Local Service');
        $mail->addAddress($toEmail);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Your Verification OTP';
        $mail->Body = "<b>Your verification code is: $otp</b><br>Please enter this code to verify your account.";
        $mail->AltBody = "Your verification code is: $otp";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
?>