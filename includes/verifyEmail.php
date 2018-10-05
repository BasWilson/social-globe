<?php

require 'config.php';
require 'log.php';

session_start();
$id = $_POST['id'];

$query = "SELECT verification_id, id FROM users WHERE verification_id = '$id'";
$result = mysqli_query($mysqli, $query);

if ($row = mysqli_fetch_array($result)) {

    $user_id = $row['id'];
    $query_update = "UPDATE users SET verified = 1 WHERE id = $user_id";

    if (mysqli_query($mysqli, $query_update)) {
        $_SESSION['verified'] = 1;
        echo true; // laat ajax weten dat het goed is
    } else {
        echo false;
    }
} else {
    return false;
}
