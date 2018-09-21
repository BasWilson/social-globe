<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// database logingegevens
$db_hostname = 'localhost';
$db_username = 'socialglobe';
$db_password = 'thisisfun@99';
$db_database = 'social_globe';

// maak de database-verbinding
$mysqli = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

if (!$mysqli) {
   echo "connection error"; 
}