<?php

session_start();


if($_SESSION['uid']==true){

}
else {
  header("Location: login.php");
}
?>
