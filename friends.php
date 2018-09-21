<?php
session_start();

if(!$_SESSION['email']){
  header("Location: login.php");
} else {
  ?>
  <style media="screen">
    #logout-btn {
      display: flex;
    }
  </style>
  <?php
  }
if($_SESSION['email']){


require 'includes/config.php';
include 'log.php';

$query = 'SELECT * FROM users ORDER BY first_name';

$result = mysqli_query($mysqli, $query);
}
?>
<!DOCTYPE html>

<html style="margin-top:10px;margin-bottom:10px;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your friends - Social Globe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div>
        <nav id="navbar" class="navbar navbar-light navbar-expand-md navigation-clean-button">
            <div class="container"><a class="navbar-brand" href="#">Social Globe</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse"
                    id="navcol-1">
                    <ul class="nav navbar-nav mr-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="index.php">The Globe</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="profile.php">Profile</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Friends</a></li>
                        <li class="nav-item" role="presentation"><span onclick="OpenHelpModal()" style="cursor: pointer"><a class="nav-link">Help</a></span></li>
                        <li>
                        </ul><span class="navbar-text actions"> <a href="logout.php" class="login">Sign out</a><a class="btn btn-light action-button" role="button" onclick="OpenNewPost()">New post</a></span></div>
            </div>
        </nav>
    </div>
    <div id="add-container" style="display: none;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="margin-top:10px;margin-bottom:10px;">Post to the globe</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <p style="margin-top:10px;margin-bottom:10px;"><strong>What's on your mind?</strong></p>
                    <textarea class="form-control" type="text" id="textField" required="" placeholder="Maximum 1000 characters" maxlength="1000" minlength="2" autofocus="" style="margin-bottom:10px;margin-top:10px;"></textarea>
                    <p style="margin-top:10px;margin-bottom:10px;"><strong>Visibility</strong></p>
                    <select class="form-control" id="visibilityField" style="margin-top:10px;margin-bottom:10px;width: 150px">
                        <optgroup label="Visibility">
                            <option id="public-option" value="public" selected="">Public</option>
                            <option id="friends-option" value="friends">My friends</option>
                        </optgroup>
                    </select>
                        <button onclick="AddUser()" class="btn btn-primary" type="button" style="margin-top:10px;margin-bottom:10px;">Post</button>
                        <button onclick="CloseAddUser()" class="btn btn-primary" type="button" style="background-color: orange; margin: 10px; border-color: orange;">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div id="modal-popup" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span><br>
        <h3 id="modal-text" >Some text in the Modal..</h3><br>
        <p id="confirm-fn"></p>
        <p id="confirm-ln"></p>
        <p id="confirm-g"></p>
        <p id="confirm-dob"></p>
        <button id="confirmSaveBtn" onclick="ConfirmSave()" class="btn btn-primary" type="button" style="margin-top:10px;margin-bottom:10px;width: 150px; display:none">Yes</button>
        <button id="confirmDelBtn" onclick="ConfirmDelete()" class="btn btn-primary" type="button" style="margin-top:10px;margin-bottom:10px;width: 150px; display:none">Yes</button>
        </div>

    </div>

    <!-- The help Modal -->
    <div id="help-modal-popup" class="help-modal">

        <!-- Modal content -->
        <div class="help-modal-content">
        <span onclick="CloseModal()" class="close">&times;</span><br>
        <h3 id="modal-text" >Some help with the CRUD system</h3><br>
        <ul>
            <li>You can sort users by using the sort menu in the nav bar.</li>
            <li>By pressing edit you can change user details.</li>
            <li>By pressing delete you delete that user permanently.</li>
            <li>By pressing an image next to a user you can change it.</li>
        </ul>
        <button onclick="CloseModal()" class="btn btn-primary" type="button" style="margin-top:10px;margin-bottom:10px;width: 150px;">I understand</button>
        </div>

    </div>

    <!-- The Image Upload Modal -->
    <div id="image-modal-popup" class="image-modal">

        <!-- Modal content -->
        <div class="image-modal-content">
        <span onclick="CloseModal()" class="close">&times;</span><br>
        <h3 id="image-modal-text" >Upload a new image for this user.</h3><br>
        <img id="modal-image" style="width: 200px; border-radius: 8px; margin-bottom: 20px;" />
        <p>Pick new image (You might need to refresh the page after changing an image.)</p>
        <p>Image requirements:</p>
        <ul>
            <li>Smaller than 500KB.</li>
            <li>One of these formats: 'jpeg', 'jpg', 'png', 'gif', 'bmp'.</li>
        </ul>
        <form id="image-form" method="post" enctype="multipart/form-data">
            <input id="uploadImage" type="file" accept="image/*" name="image"/><br><br>
            <input type="name" id="pic-id" name="id" style="display: none;">
            <input class="btn btn-success" type="submit" value="Upload">
        </form>
        </div>

    </div>

    <!-- The temp info box -->
    <div id="noti-box" class="noti-box">
        <div class="noti-content">
            <p id="noti-text">Some notification to be shown</p>
        </div>
    </div>
    <footer>
        <p>Made by Nick Voerman (81324) and Bas Wilson (82399), Students at Grafisch Lyceum Rotterdam.</p>
        <p>Backend 2, period 1.</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/interaction.js"></script>
    <script src="assets/js/database.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>

    <?php
        if (!$_SESSION['new']) {
        $_SESSION['new'] = true;
        ?>
        <script>OpenHelpModal()</script>
    <?php
    }
    ?>
    </body>

</html>
