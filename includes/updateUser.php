<?php

  include 'log.php';  

  $id = $_POST['id'];
  $fn = $_POST['fn'];
  $ln = $_POST['ln'];
  $g = $_POST['g'];
  $dob = $_POST['dob'];

if(isset($id) || isset($fn) || isset($ln) || isset($g) || isset($dob)) {
  //Alle data is er

//Door de validate functie krijgen we uit de data of het compleet en correct is
if (Validate($id, $fn, $dob, $ln, $g)) {
  UpdateUser($id, $fn, $ln, $g, $dob);
} else {
  echo false;
}
} else {
  echo false;
}

function UpdateUser($id, $fn, $ln, $g, $dob) {

  require 'config.php';

  $query = "UPDATE mphp4_leden SET first_name = '$fn', last_name = '$ln', gender = '$g', birth_date = '$dob' WHERE id = $id";

  if (mysqli_query($mysqli, $query)) {
    echo true; // laat ajax weten dat het goed is
} else {
    echo false;
  }

}

//Door de validate functie krijgen we uit de data of het compleet en correct is
function Validate ($id, $fn, $dob, $ln, $g) {

  require 'config.php';

  //Check of de waarden niet leeg zijn
  if ($fn != "" && $ln != "" && $g != "") {
      ChromePhp::log("Not empty");
      if (!ContainsNumbers($fn) && !ContainsNumbers($ln) && !ContainsNumbers($g)) {
          ChromePhp::log("Strings dont contain numbers");            
          if (IsGender($g)) {
              ChromePhp::log("gender is okay");
              //Check of de datum echt een datum is en ook niet ouder groter dan de join date
              $joinDateQuery = "SELECT * FROM mphp4_leden WHERE id = '$id'"; 
              
              $dateResult = mysqli_query($mysqli, $joinDateQuery);
              if ($row = mysqli_fetch_assoc($dateResult)) {
                
                $timeOne = strtotime($row["member_since"]);
                $timeTwo = strtotime($dob);

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
            }
          }
      } else {
        echo "Names can not contain numbers.";
      }
  } else {
    echo "Please fill in all fields.";
  }
}

function IsGender($gender) {
  if ($gender == "m" || $gender == "f") {
      return true;
  }
  return false;
}

function ContainsNumbers($String){
  return preg_match('/\\d/', $String) > 0;
}

