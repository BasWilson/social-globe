<!DOCTYPE html>

<html style="margin-top:10px;margin-bottom:10px;">

<head>
    <link rel="shortcut icon" href="assets/img/socialglobe_logo.png" type="image/png"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your profile - Social Globe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div>
        <nav id="navbar" class="navbar navbar-light navbar-expand-md navigation-clean-button">
            <div class="container"><a class="navbar-brand" href="#"><img src="assets/img/socialglobe_logo.png" style="width:90px; height:86px"  alt="logo"> </a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse"
                    id="navcol-1">
                    <ul class="nav navbar-nav mr-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="index.php">The Globe</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Profile</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="friends.php">Friends</a></li>
                        <li class="nav-item" role="presentation"><span onclick="OpenHelpModal()" style="cursor: pointer"><a class="nav-link">New features</a></span></li>
                        <li>
                        </ul><span class="navbar-text actions"> <a href="logout.php" class="login">Sign out</a><a class="btn btn-light action-button" role="button" onclick="OpenNewPost()">New post</a></span></div>
            </div>
        </nav>
    </div>


    <main>
    <!-- PROFILE -->
    <div class="container">
        <div class="row">
            <img id="loader" src="assets/img/loading.svg" />
            <div id="profile-container" class="col-md-12">
                <div class="profile-card">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    </main>

    <!-- The temp info box -->
    <div id="noti-box" class="noti-box">
        <div class="noti-content">
            <p id="noti-text">Some notification to be shown</p>
        </div>
    </div>
    <footer>
        <p>Made by Nick Voerman (81324) and Bas Wilson (82399), Students at Grafisch Lyceum Rotterdam.</p>
        <p>Social Globe®</p>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/interaction.js"></script>
    <script src="assets/js/jscolor.js"></script>
    <script src="assets/js/database.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>
    <script>VerifyEmail()</script>
    </body>

</html>
