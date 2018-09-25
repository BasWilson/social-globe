<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in to Social Globe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div>
        <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
            <div class="container"><a class="navbar-brand" href="#">Social Globe</a>
            </div>
        </nav>
    </div>
        <!-- The login box -->
    <div id="login-container" class="login-clean">
        <form style="text-align: center">
            <h3 style="margin-bottom: 20px;" >Returning user</h3>
            <div class="form-group"><input class="form-control" type="email" id="emailFieldLogIn" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" id="passwordFieldLogIn" placeholder="Password"></div>
            <div class="form-group"><a class="btn btn-primary btn-block" style="color:white;" onclick="UserLogin()">Log In</a></div>
            <a style="cursor: pointer;" onclick="SwitchLoginScreen(0)">New user? Sign up instead.</a>
        </form>
    </div>

        <!-- The signup box -->
    <div style="display: none;" id="signup-container" class="login-clean">
        <form style="text-align: center">
        <h3 style="margin-bottom: 20px;" >New user</h3>
            <div class="form-group"><input class="form-control" type="name" id="fnFieldSignUp" placeholder="First name"></div>
            <div class="form-group"><input class="form-control" type="name" id="lnFieldSignUp" placeholder="Surname"></div>
            <p style="margin-top:10px;margin-bottom:10px; text-align: left !important;"><strong>Birth date</strong></p>
            <div class="form-group"><input class="form-control" type="date" id="dateFieldSignUp" placeholder="Date of birth"></div>
            <div class="form-group"><input class="form-control" type="email" id="emailFieldSignUp" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" id="passwordFieldSignUp" placeholder="Password"></div>
            <div class="form-group"><a class="btn btn-primary btn-block" style="color:white;" onclick="UserSignUp()">Sign up</a></div>
            <a style="cursor: pointer;" onclick="SwitchLoginScreen(1)">Returning user? Log in.</a>
        </form>
    </div>

        <!-- The temp info box -->
    <div id="noti-box" class="noti-box"> 
        <div class="noti-content">
            <p id="noti-text">Some notification to be shown</p>
        </div>
    </div>
    <footer>
        <p>Made by Bas Wilson (82399), Student at Grafisch Lyceum Rotterdam.</p>
        <p>Backend 2, period 1.</p>
    </footer>
    <script src="assets/js/interaction.js"></script>
    <script src="assets/js/database.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>