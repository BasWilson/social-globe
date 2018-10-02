<?php
    session_start();
    //require 'config.php';
    if($_SESSION['email']){
    echo '
    <div class="profile-card">
        <img id="profile-image" onclick="OpenImageUpload()" src="profile_pics/'.$_SESSION['profile_pic'].'" class="profile-image card-item" />
        <p>click on the picture to upload your profile picture </p><br>

  <div class="profile-edit-change">

  <label>First Name</label><br>
    <input type="text" class="form-control" name="first_name" value=" '.$_SESSION['first_name'].'" readonly> <br>
  <label>Last Name</label><br>
    <input type="text" class="form-control" name="last_name" value=" '.$_SESSION['last_name'].'" readonly> <br>
  <a class="profile-edit-button" onclick="EditProfile()"><img src="assets/img/edit.png"/></a>
    </div>



  <div id="profile-edit1-change">

<form name="form1" method="post" action="">
<label>First Name</label><br>
  <input type="text" class="form-control" name="first_name" value=" '.$_SESSION['first_name'].'"> <br>
<label>Last Name</label><br>
  <input type="text" class="form-control" name="last_name" value=" '.$_SESSION['last_name'].'"> <br>
<input style="width:25px;" onclick="ChangeProfile()" class="profile-edit-button" type="image" src="assets/img/checkmark.png" alt="profilebutton" />
</form>
</div>
</div>

';
}
