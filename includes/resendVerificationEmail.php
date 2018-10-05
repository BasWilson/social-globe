<?php

require 'config.php';
require 'log.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../mailer/Exception.php';
require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';

session_start();

$username = $_SESSION['username'];

$query = "SELECT verification_id, username, email FROM users WHERE username = '$username'";
$result = mysqli_query($mysqli, $query);
if ($row = mysqli_fetch_array($result)) {

    $email = $row['email'];
    $username = $row['username'];
    $email_id = $row['verification_id'];
    SendWelcomeEmail($email, $username, $email_id);

} else {
    return false;
}


function SendWelcomeEmail($email, $username, $email_id) {

    $to = $email;
    $subject = "Welcome to The Social Globe";
    
    $message = '
    <html>
    <head>
    <title>Welcome to The Social Globe, ".$username."</title>
    </head>
    <body>
    <p>Hi there '.$username.',</p>
    <p>We want to welcome you to The Social Globe, by clicking the link at the bottom of this email you will verify your account so you can use The Social Globe.</p>
    <a href="https://www.82399.ict-lab.nl/social-globe/verify.php?id='.$email_id.'" >Verify email</a>

    <p>Have fun!</p>
    <p>The Social Globe team.</p>
    </body>
    </html>
    ';
    
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // More headers
    $headers .= 'From: <noreply@baswilson.com>' . "\r\n";
    
    mail($to,$subject,$message,$headers);

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'baswilson.com;baswilson.com';            // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'noreply@baswilson.com';                 // SMTP username
    $mail->Password = 'yR{hXy-G{UB^';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('noreply@baswilson.com', 'The Social Globe');
    $mail->addAddress($email, $username);     // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Welcome to The Social Globe';
    $mail->Body    = $message;

    $mail->send();
    
} catch (Exception $e) {
}
    echo true;
}