<?php

require 'config.php';
include 'log.php'; // is een tool om met de chrome console php te debuggen
session_start();

$post = $_POST['post'];
$color = $_POST['color'];
$username = $_SESSION['username'];

//Door de validate functie krijgen we uit de data of het compleet en correct is
if (Validate($post, $username, $color)) {

    //Maak de datum van vandaag als de lid sinds waarde


    $queryP = "SELECT first_name, last_name, profile_pic FROM users WHERE username = '$username'";
    $result = mysqli_query($mysqli, $queryP);

    if ($row = mysqli_fetch_array($result)) {

        $color = $color . '0.4)';

        $query = "INSERT INTO posts VALUES (null,'$username','$post',null, '$color', 0)";

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
function Validate ($post, $username, $color) {

    //Check of de waarden niet leeg zijn
    if ($post != "" && $username != "") {
                return true;
    } else {
        echo "Make sure you entered a post";
    }
  }

?>
