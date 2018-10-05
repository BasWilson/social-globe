<?php
session_start();

function LoginOkay () {
    if(!$_SESSION['username']){
        header("Location: login.php");
      } else {
          if ($_SESSION['verified'] != 1) {
              header("Location: resend-verification.php");
          } else {
              return true;
          }
      }
}
