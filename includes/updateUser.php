<?php

  include 'log.php';
  session_start();
  $id = $_SESSION['id'];
  $fn = $_POST['fn'];
  $ln = $_POST['ln'];
  $username = $_POST['u'];


if(isset($id) || isset($fn) || isset($ln) || isset($username)) {



  //Door de validate functie krijgen we uit de data of het compleet en correct is
  if (Validate($id, $fn, $ln, $username)) {
    UpdateUser($id, $fn, $ln, $username);
  } else {
    echo false;
  }

}
 else {
  echo false;
}

function UpdateUser($id, $fn, $ln, $username) {


  require 'config.php';

  $sql_u = "SELECT username FROM users WHERE username='$username'";
  $res_u = mysqli_query($mysqli, $sql_u);
  $row = mysqli_fetch_array($res_u);

  if ($row['username'] == $username) {
    //same username
    $query = "UPDATE users SET username = '$username', first_name = '$fn', last_name = '$ln' WHERE id = $id";
    $_SESSION['first_name'] = $fn;
    $_SESSION['last_name'] = $ln;
    $_SESSION['username'] = $username;

    if (mysqli_query($mysqli, $query)) {
      echo true; // laat ajax weten dat het goed is
    } else {
        echo false;
    }

  } else {
    if (mysqli_num_rows($res_u) > 0) {
      echo "This username has already been taken";
      return false;
    } else {
      $query = "UPDATE users SET username = '$username', first_name = '$fn', last_name = '$ln' WHERE id = $id";
      $_SESSION['first_name'] = $fn;
      $_SESSION['last_name'] = $ln;
      $_SESSION['username'] = $username;

      if (mysqli_query($mysqli, $query)) {
        echo true; // laat ajax weten dat het goed is
      } else {
        echo false;
      }
    }
  }

}

//Door de validate functie krijgen we uit de data of het compleet en correct is
function Validate ($id, $fn, $ln, $username) {

  require 'config.php';

  //Check of de waarden niet leeg zijn
  if ($fn != "" && $ln != "" && $username != "") {
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
