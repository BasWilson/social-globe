<?php
session_start();
$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp'); // Goede extensies
$path = '../profile_pics/'; //Plek waar de fotos in komen

if(!empty($_POST['id']) || $_FILES['image'])
{

    $img = $_FILES['image']['name']; //FOTO
    $id = $_SESSION['id']; // USER ID
    $tmp = $_FILES['image']['tmp_name'];

    //De bestands extensie
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    // Foto naam is de id van de  user + _image, op deze manier overshcrijven we de oude
    $final_image = $id."_image.".$ext;

    // Kijk if the extensie goed is.
    if(in_array($ext, $valid_extensions)) {

        //Kijk of het bestand minder dan 500kb is
        if($_FILES['image']['size'] < 500000){

            $path = $path.strtolower($final_image);

            if(move_uploaded_file($tmp,$path)) {

                //config.php erbij betrekken
                include_once 'config.php';

                //UPDATEN in de db
                $query = "UPDATE users SET profile_pic = '$path' WHERE id = $id";
            $_SESSION['profile_pic'] = $path;
            if (mysqli_query($mysqli, $query)) {
                echo true; // foto is geupload en in de database
            } else {
                echo "Connection with the database could not be established"; // foto is geupload maar niet in de db
            }
            //Error met het moven naar de path;
            } else {
                echo "Failed to move to path";
            }

        } else {
            echo 'File size is larger than 500KB';
        }

    } else {
        echo "This file format is not allowed"; // geen goede extensie van de image, foto is niet geupload
    }
}
?>
