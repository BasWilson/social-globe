<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../mailer/Exception.php';
require '../mailer/PHPMailer.php';
require '../mailer/SMTP.php';

require 'config.php';
include 'log.php'; // is een tool om met de chrome console php te debuggen
$name = $_POST['fn'];
$lastname = $_POST['ln'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

//Door de validate functie krijgen we uit de data of het compleet en correct is
if (Validate($name, $dob, $lastname, $email, $password, $username)) {

    //Maak de datum van vandaag als de lid sinds waarde
    $date = date('Y-m-d H:i:s'); 

    //De standaard foto van een gebruiker
    $genderPic = 'default.jpg';
    
    //Vul het in
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $name = ucfirst($name);
    $lastname = ucfirst($lastname);

    $email_id = rand(0, 1000000000) + rand(0, 1000000000);
    
    $query = "INSERT INTO users VALUES ('$username', '$name','$lastname','$email','$dob','$hashedPass', '$date', '$genderPic', NULL, '$email_id', 0)";

    if (mysqli_query($mysqli,$query))
    {
        echo true; // laat ajax weten dat het goed is
        session_start(); // start de sessie
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['first_name'] = $name;
        $_SESSION['last_name'] = $lastname;
        $_SESSION['dob'] = $dob;
        $_SESSION['date_joined'] = $date;
        $_SESSION['verified'] = 0;

        $query = "SELECT id FROM users WHERE username = '$username'";

        $result = mysqli_query($mysqli, $query);
        
        
        if ($row = mysqli_fetch_assoc($result)) { 
            $_SESSION['id'] = $row['id'];
            SendWelcomeEmail($email, $username, $email_id);
        }
        
        $_SESSION['profile_pic'] = $genderPic;
        $_SESSION['new'] = false; // zet een session variable met new zodat de site weet de gebruiker het help menu te laten zien
    }
    else
    {
        echo false; // laat ajax weten dat het fout is
        session_start();
        session_destroy(); // maak de sessie kapot om gekke dingen te voorkomen
        echo "This username is already in use";
    }
} else {
    echo false;
}

//Door de validate functie krijgen we uit de data of het compleet en correct is
function Validate ($name, $dob, $lastname, $email, $password, $username) {

    require 'config.php';
  
    //Check of de waarden niet leeg zijn
    if ($name != "" && $lastname != "" && $password != "" && $dob != "" && $email != "" && $username != "") {
        ChromePhp::log("Not empty");
        if (!ContainsNumbers($name) && !ContainsNumbers($lastname)) {
            ChromePhp::log("Strings dont contain numbers");            
                $oDate = date('Y-m-d H:i:s'); 
                $timeTwo = strtotime($dob);
                $timeOne = strtotime($oDate);
                
                  if ($timeOne > $timeTwo) {
                    $arr = explode('-', $dob);
                    if (count($arr) == 3) {
                        ChromePhp::log("3 values");
                        //Er bestaan 3 array entries
                        if (checkdate($arr[1], $arr[2], $arr[0])) {
                            //Alles oke
                            ChromePhp::log("date okay");
                            return true;
                        }
                    }
                } else {
                    echo "Birth date has to be earlier than the current date.";
                }
        } else {
            echo "Names can not contain numbers.";
        }
    } else {
        echo "Please fill in all fields.";
    }
  }


function ContainsNumbers($String){
    return preg_match('/\\d/', $String) > 0;
}

/*
nwytg.net
ln0ut.net
yuoia.com
wimsg.com
20mail.it
*/
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

}
?>

