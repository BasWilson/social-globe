<?php
    session_start();
    //require 'config.php';
    if($_SESSION['email']){
    echo '
    <div class="profile-card">
<<<<<<< HEAD
        <img id="profile-image" onclick="OpenImageUpload()" src="profile_pics/'.$_SESSION['profile_pic'].'" class="profile-image card-item" />
        <p>click on the picture to upload your post </p><br>

<div class="profile-edit-change">
        <p> email: </p>
        <p class="card-item">'. $_SESSION['email'] .'</p><br>
        <p> first name: </p>
        <p class="card-item">'. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] .'</p>
        <a class="profile-edit-button" onclick="EditProfile()"><img src="assets/img/edit.png"/></a>
</div>
';
echo "<div id='profile-edit1-change'>";


?>
<p> suck penis </p>


<a class="profile-edit-button" onclick="EditProfile()"><img src="assets/img/checkmark.png"/></a>
</div>


    </div>

    }
?>
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
