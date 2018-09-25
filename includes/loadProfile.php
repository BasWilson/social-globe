<?php
    session_start();
    //require 'config.php';
    if($_SESSION['email']){
    echo '
    <div class="profile-card">
        <img src="profile_pics/'.$_SESSION['profile_pic'].'" class="profile-image card-item" />
        <p class="card-item">'. $_SESSION['email'] .'</p>
        <p class="card-item">'. $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] .'</p>
        <a class="profile-edit-button" onclick="EditProfile()"><img src="assets/img/edit.png"/></a>
    </div>
    ';
    }
?>