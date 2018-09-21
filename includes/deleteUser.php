<?php

$id = $_POST['id'];

if(isset($id)) {
  DeleteUser($id);
} else {
  echo false;
}

//Delete de gebruiker via het id
function DeleteUser($id) {

  require 'config.php';

  $query = "DELETE FROM mphp4_leden WHERE id = $id";

  if (mysqli_query($mysqli, $query)) {
    echo true; // laat ajax weten
  } else {
    echo false;
  }

}

?>
