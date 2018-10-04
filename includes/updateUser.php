<?php

  include 'log.php';
  session_start();
  $id = $_SESSION['id'];
  $fn = $_POST['fn'];
  $ln = $_POST['ln'];


if(isset($id) || isset($fn) || isset($ln)) {

  //Door de validate functie krijgen we uit de data of het compleet en correct is
  if (Validate($id, $fn, $ln)) {
    UpdateUser($id, $fn, $ln);
  } else {
    echo false;
  }
} else {
  echo false;
}

function UpdateUser($id, $fn, $ln) {


  require 'config.php';

  $query = "UPDATE users SET first_name = '$fn', last_name = '$ln' WHERE id = $id";
  $_SESSION['first_name'] = $fn;
  $_SESSION['last_name'] = $ln;

  if (mysqli_query($mysqli, $query)) {
    echo true; // laat ajax weten dat het goed is
} else {
    echo false;
  }

}

//Door de validate functie krijgen we uit de data of het compleet en correct is
function Validate ($id, $fn, $ln) {

  require 'config.php';

  //Check of de waarden niet leeg zijn
  if ($fn != "" && $ln != "") {
      if (!ContainsNumbers($fn) && !ContainsNumbers($ln)) {
        return true;
      } else {
        echo "Names can not contain numbers.";
        return false;
      }
  } else {
    echo "Please fill in all fields.";
    return false;
  }
}

function ContainsNumbers($String){
  return preg_match('/\\d/', $String) > 0;
}

