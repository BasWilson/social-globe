<?php

require 'config.php';
include 'log.php'; // is een tool om met de chrome console php te debuggen
$name = $_POST['fn'];
$lastname = $_POST['ln'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$password = $_POST['password'];

ChromePhp::log($password);
//Door de validate functie krijgen we uit de data of het compleet en correct is
if (Validate($name, $dob, $lastname, $email, $password)) {

    //Maak de datum van vandaag als de lid sinds waarde
    $date = date('Y-m-d H:i:s'); 

    //De standaard foto van een gebruiker
    $genderPic = 'default.jpg';
    
    //Vul het in
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $name = ucfirst($name);
    $lastname = ucfirst($lastname);
    
    $query = "INSERT INTO users VALUES ('$name','$lastname','$email','$dob','$hashedPass', '$date', '$genderPic', NULL)";

    if (mysqli_query($mysqli,$query))
    {
        echo true; // laat ajax weten dat het goed is
        session_start(); // start de sessie
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $name;
        $_SESSION['last_name'] = $lastname;
        $_SESSION['dob'] = $dob;
        $_SESSION['date_joined'] = $date;

        $query = "SELECT id FROM users WHERE email = '$email'";

        $result = mysqli_query($mysqli, $query);
        
        
        if ($row = mysqli_fetch_assoc($result)) { // bestaat
            $_SESSION['id'] = $row['id'];
        }
        
        $_SESSION['profile_pic'] = $genderPic;
        $_SESSION['new'] = false; // zet een session variable met new zodat de site weet de gebruiker het help menu te laten zien
    }
    else
    {
        echo false; // laat ajax weten dat het fout is
        session_start();
        session_destroy(); // maak de sessie kapot om gekke dingen te voorkomen
        echo "Something is not quite right, this email might already be in use.";
    }
} else {
    echo false;
}

//Door de validate functie krijgen we uit de data of het compleet en correct is
function Validate ($name, $dob, $lastname, $email, $password) {

    require 'config.php';
  
    //Check of de waarden niet leeg zijn
    if ($name != "" && $lastname != "" && $password != "" && $dob != "" && $email != "") {
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

?>