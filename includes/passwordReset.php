<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../mailer/Exception.php';
    require '../mailer/PHPMailer.php';
    require '../mailer/SMTP.php';
    require 'config.php';
    include 'log.php';

    $type = "allow";

    if (isset($_POST['type'])) {
        $type = $_POST['type'];
    }
    
    if ($type == 'email') {
        SendResetMail();
    } else if ($type == "reset") {
        ResetPassword();
    } else {
        CheckIfResetAllowed();
    }
    function CheckIfResetAllowed () {

        $reset_id = $_POST['reset_id'];
        $query = "SELECT password_reset_id FROM users WHERE password_reset_id = '$reset_id'";
        $result = mysqli_query($mysqli, $query);

        if ($row = mysqli_fetch_array($result)) {
            if ($reset_id == $row['password_reset_id']) {
                //Allowed to reset
                return true;
            }
        }
        return false;
    }

    function SendResetMail () {

        require 'config.php';

        $username = $_POST['username'];

        $query = "SELECT email FROM users WHERE username = '$username'";
        $result = mysqli_query($mysqli, $query);

        $reset_id = rand(0, 1000000000) + rand(0, 1000000000);

        $query2 = "UPDATE users SET password_reset_id = '$reset_id' WHERE username = '$username'";
    
        if (mysqli_query($mysqli, $query2)) {

            if ($row = mysqli_fetch_array($result)) {
            
                $to = $row['email'];
                $subject = "Reset password";
                
                $message = '
                <html>
                <head>
                <title>Password reset for '.$username.'</title>
                </head>
                <body>
                <p>Hi there '.$username.',</p>
                <p>You requested to reset your password, by clicking below you can do so.</p> <p>If this was not you, then please delete this email.</p>
                <a href="https://www.82399.ict-lab.nl/social-globe/reset-password.php?id='.$reset_id.'" >Reset password</a>
            
                <p>Good luck!</p>
                <p>The Social Globe team.</p>
                </body>
                </html>
                ';
                
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                
                // More headers
                $headers .= 'From: <noreply@baswilson.com>' . "\r\n";
                
            
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
                $mail->addAddress($row['email'], $username);     // Add a recipient
            
                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Password Reset';
                $mail->Body    = $message;
            
                $mail->send();
                
            } catch (Exception $e) {
            }
                echo true;
            } else {
                echo false;
            }
        }

        return false;
    }
    function ResetPassword() {

        require 'config.php';

        $username = $_POST['username'];
        $password = $_POST['password'];
        $reset_id = $_POST['reset_id'];

        if (isset($username) && isset($password) && isset($reset_id)) {
            if (Validate($username, $password)) {

                $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    
                $query = "UPDATE users SET password_reset_id = NULL, password = '$hashedPass' WHERE username = '$username' AND password_reset_id = '$reset_id'";
    
                if (mysqli_query($mysqli, $query)) {
                    echo 2; // password reset is done
                } else {
                    echo false;
                }
    
            }
        }

        
    }

    function Validate ($username, $password) {

        //Check of de waarden niet leeg zijn
        if ($password != "" && $username != "") {
            return true;
        } else {
            echo "Please fill in all fields.";
            return false;
        }
      }