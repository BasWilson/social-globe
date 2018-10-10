<?php

require 'checkUser.php';
require 'config.php';
include 'log.php';
LoginOkay();

$username = $_POST['username']; // The account that is being followed
$username_follower = $_SESSION['username']; // The user that is requesting to follow

//Door de validate functie krijgen we uit de data of het compleet en correct is
if (Validate($username)) {

    if(isset($username_follower) || isset($username)) {
        //Alle data is er
        Follow($username_follower, $username);
      } else {
        echo false;
      }
} else {
    echo false;
}

function Follow($username_follower, $username) {
      
    require 'config.php';
  
    if ($username_follower != $username) {
        $query4 = "SELECT * FROM users_followers WHERE username = '$username' AND follower = '$username_follower'";
  
        $result4 = mysqli_query($mysqli, $query4);
      
        if ($row4 = mysqli_fetch_array($result4)) {
          echo 3; // User is already following this user
        } else {
    
          $query3 = "INSERT INTO users_followers VALUES ('$username', '$username_follower')";
    
            if (mysqli_query($mysqli, $query3)) {
                echo true; // Is now following
            } else {
                echo false; // The query failed
            }
        }
    } else {
        echo 4;
    }
  }

function Validate ($username) {

    if ($username != "") {
        return true;
    } else {
        echo "Oops, are you sure you actually want to follow some one?";
    }
}

?>
