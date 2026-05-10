<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Adjust path as needed
require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../Project/ForgotPassword/Email/PHPMailer/src/SMTP.php';

// Generic Send Email Function
function sendEmail($toEmail, $subject, $body)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // Credentials
        $mail->Username = '0samsung7865@gmail.com';
        $mail->Password = 'xidtwgbyoljjhxqg';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('no-reply@hyperlocal.com', 'Hyper Local Service');
        $mail->addAddress($toEmail);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function sendVerificationEmail($toEmail, $token)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication

        // IMPORTANT: Use your Google Account App Password, NOT your regular password.
        // Go to Google Account > Security > 2-Step Verification > App Passwords to generate one.
        $mail->Username = '0samsung7865@gmail.com';                     //SMTP username
        $mail->Password = 'xidtwgbyoljjhxqg';                               //SMTP password (16 characters, no spaces)

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port = 587;                                    //TCP port to connect to

        //Recipients
        $mail->setFrom('no-reply@hyperlocal.com', 'Hyper Local Service');
        $mail->addAddress($toEmail);     //Add a recipient

        //Content
        // Dynamic link generation to match your server (localhost or IP)
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $path = dirname($_SERVER['PHP_SELF']); // Gets the directory of the calling script (signup.php)
        $verifyLink = "$protocol://$host$path/verify_email.php?token=" . urlencode($token);

        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Verify Your Account';
        $mail->Body = "<b>Welcome!</b><br>Please click the link below to verify your account:<br><br><a href='$verifyLink'>Verify Account</a><br><br>Or copy this link:<br>$verifyLink";
        $mail->AltBody = "Please verify your account by visiting: $verifyLink";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>