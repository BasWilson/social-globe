<?php
    session_start();
    //require 'config.php';
    if($_SESSION['email']){
    echo '
    <div class="profile-card">
        <img id="profile-image" onclick="OpenImageUpload()" src="profile_pics/'.$_SESSION['profile_pic'].'" class="profile-image card-item" />
        <p>click on the picture to upload your post </p><br>

<div class="profile-edit-change">

        <p> Name: </p>
        <p class="card-item">'. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] .'</p><br>
        <p> Email: </p>
        <p class="card-item">'. $_SESSION['email'] .'</p>
        <a class="profile-edit-button" onclick="EditProfile()"><img src="assets/img/edit.png"/></a>
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
