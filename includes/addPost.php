<?php

require 'config.php';
include 'log.php'; // is een tool om met de chrome console php te debuggen
session_start();

$post = $_POST['post'];
$color = $_POST['color'];
$email = $_SESSION['email'];

//Door de validate functie krijgen we uit de data of het compleet en correct is
if (Validate($post, $email, $color)) {

    //Maak de datum van vandaag als de lid sinds waarde
    $postTime = date('Y-m-d H:i:s'); 

    $queryP = "SELECT first_name, last_name, profile_pic FROM users WHERE email = '$email'";
    $result = mysqli_query($mysqli, $queryP);

    if ($row = mysqli_fetch_array($result)) {

        $name = $row['first_name'] . " " . $row['last_name'];
        $profile_pic = $row['profile_pic'];
        $color = $color . '0.4)';
    
        $query = "INSERT INTO posts VALUES (null,'$email','$post','$postTime', '$name', '$profile_pic', '$color')";
    
        if (mysqli_query($mysqli,$query))
        {
            echo true; // laat ajax weten dat het goed is
        }
        else
        {
            echo false; // laat ajax weten dat het fout is
            echo "Connection could not be established. Please try again later.";
        }
    } else {
        return false;
        echo "Can't find user in database.";
    }

} else {
    echo false;
}

//Door de validate functie krijgen we uit de data of het compleet en correct is
function Validate ($post, $email, $color) {
  
    //Check of de waarden niet leeg zijn
    if ($post != "" && $email != "") {
        ChromePhp::log("Not empty");
                return true;
    } else {
        echo "Make sure you entered a post";
    }
  }

?>