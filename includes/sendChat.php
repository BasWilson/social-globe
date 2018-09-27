<?php

require 'config.php';
include 'log.php'; // is een tool om met de chrome console php te debuggen
session_start();

$message = $_POST['message'];
$email = $_SESSION['email'];
$name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];

//Door de validate functie krijgen we uit de data of het compleet en correct is
if (Validate($message, $email, $name)) {

    //Maak de datum van vandaag als de lid sinds waarde
    $query = "INSERT INTO global_chat VALUES (null,'$message','$email','$name', null)";

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
    echo false;
}

//Door de validate functie krijgen we uit de data of het compleet en correct is
function Validate ($message, $email, $name) {
  
    //Check of de waarden niet leeg zijn
    if ($message != "" && $email != "" && $name != "") {
        return true;
    } else {
        echo "Make sure you entered a message";
    }
  }

?>