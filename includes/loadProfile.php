<?php
    session_start();
    //require 'config.php';
    if($_SESSION['email']){
    echo '
    <div class="profile-card">
<<<<<<< HEAD
<<<<<<< HEAD
        <img id="profile-image" onclick="OpenImageUpload()" src="profile_pics/'.$_SESSION['profile_pic'].'" class="profile-image card-item" />
        <p>click on the picture to upload your post </p><br>

<div class="profile-edit-change">

        <p> Name: </p>
        <p class="card-item">'. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] .'</p><br>
        <p> Email: </p>
=======
        <img src="profile_pics/'.$_SESSION['profile_pic'].'" class="profile-image card-item" />
>>>>>>> parent of 3728d6b... dingen gefixt alleen de php profile werkt niet geen idee wat er fout is
        <p class="card-item">'. $_SESSION['email'] .'</p>
        <p class="card-item">'. $_SESSION['id'] .'</p>
        <p class="card-item">'. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] .'</p>
        <a class="profile-edit-button" onclick="EditProfile()"><img src="assets/img/edit.png"/></a>
<<<<<<< HEAD
</div>

';
echo "<div id='profile-edit1-change'>";



$userid = $_SESSION['id'];

$query = "SELECT * FROM users WHERE id = '$userid'";


$resultaat = mysqli_query($mysqli, $query);

if (mysqli_num_rows($resultaat)==0) {
header("Location: profile.php");
}
else {
  $rij = mysqli_fetch_array($resultaat);
?>
<<<<<<< HEAD
=======
        <img src="profile_pics/'.$_SESSION['profile_pic'].'" class="profile-image card-item" />
        <p class="card-item">'. $_SESSION['email'] .'</p>
        <p class="card-item">'. $_SESSION['id'] .'</p>
        <p class="card-item">'. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] .'</p>
        <a class="profile-edit-button" onclick="EditProfile()"><img src="assets/img/edit.png"/></a>
    </div>
    ';
    }
?>
>>>>>>> parent of 3728d6b... dingen gefixt alleen de php profile werkt niet geen idee wat er fout is
=======


<input type="text" name="first_name" value="<?php echo $rij['first_name'] ?>">

<input type="text" name="last_name" value="<?php echo $rij['last_name'] ?>">

<input type="text" name="email" value="<?php echo $rij['email'] ?>">

<input type="submit" name="submit" value="Opslaan">




}

<p> suck penis </p>
<a class="profile-edit-button" onclick="EditProfile()"><img src="assets/img/checkmark.png"/></a>
</div>

</div>
}
>>>>>>> parent of 99acf93... shit d
=======
    </div>
    ';
    }
?>
>>>>>>> parent of 3728d6b... dingen gefixt alleen de php profile werkt niet geen idee wat er fout is
