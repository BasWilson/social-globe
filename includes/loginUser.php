<?php
  $e = $_POST['email'];
  $p = $_POST['password'];
  include 'log.php'; // is een tool om met de chrome console php te debuggen

if(isset($e) || isset($p)) {
  //Alle waarden zijn ingevuld
  LoginAdmin($e, $p);
} else {
  echo false;
}

function LoginAdmin($e, $p) {

  require 'config.php';

  //selecteer de rij waar username $u is
  $query = "SELECT * FROM users WHERE email = '$e'";

  $result = mysqli_query($mysqli, $query);
  
  
  if ($row = mysqli_fetch_assoc($result)) { // bestaat

      if ($row['email'] == $e && password_verify($p, $row['password'])) { // in deze rij is het password gelijk aan $p
          echo true; // laat ajax weten
          session_start(); // start de sessie
          $_SESSION['email'] = $e;
          $_SESSION['first_name'] = $row['first_name'];
          $_SESSION['last_name'] = $row['last_name'];
          $_SESSION['dob'] = $row['dob'];
          $_SESSION['date_joined'] = $row['date_joined'];
          $_SESSION['profile_pic'] = $row['profile_pic'];
          $_SESSION['new'] = false; // zet een session variable met new zodat de site weet de gebruiker het help menu te laten zien
        } else {
          echo false;
          session_start();
          session_destroy(); // maak de sessie kapot om gekke dingen te voorkomen
        }
  }


}
