<?php
    require 'checkUser.php';
    require 'config.php';
    include 'log.php';
    LoginOkay();
    $extra = "";
    $user = $_POST['user_id'];


    //Get the user data
    $query = "SELECT username, profile_pic, first_name, last_name FROM users WHERE username = '$user'";
    $result = mysqli_query($mysqli, $query);
    
    if ($row = mysqli_fetch_array($result)) {
        // The echo
        echo '
            <div class="profile-card">
                <img id="profile-image" src="profile_pics/'.$row['profile_pic'].'" class="profile-image card-item" />
                <div id="profile-view">
                    <p><strong><span id="username">'.$row['first_name']. " " .$row['last_name'].'</span></strong></p>
                    <p><strong><span id="name">'.$row['username'].'</span></strong></p>
                    <a id="'.$row['username'].'" onclick="FollowUser(this.id)">Follow '.$row['first_name'].'</a>
                    <p>'.$extra.'</p>
                </div>
            </div>
        ';
    }


?>