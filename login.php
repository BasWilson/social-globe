<!DOCTYPE html>
<html>

<head>
    <link rel="shortcut icon" href="assets/img/socialglobe_logo.png" type="image/png"/>
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
            <div class="container"><a class="navbar-brand" href="#"><img src="assets/img/socialglobe_logo.png" style="width:90px; height:86px"  alt="logo"> </a>
            </div>
        </nav>
    </div>
    <div style="display: none;" id="reset-container" class="login-clean">
        <form style="text-align: center">
            <h3 style="margin-bottom: 20px;" >Reset password</h3>
            <div class="form-group"><input class="form-control" type="username" id="resetUsernameField" placeholder="Current username"></div>
            <div class="form-group"><a class="modalbutton" style="color:white; cursor:pointer;" onclick="ResetPassword('email')">Reset Password</a></div>
            <a style="cursor: pointer;" onclick="SwitchLoginScreen(1)">I remembered, go back!</a>
        </form>
    </div>

        <!-- The login box -->
    <div id="login-container" class="login-clean">
        <form style="text-align: center">
            <h3 style="margin-bottom: 20px;" >Returning user</h3>
            <div class="form-group"><input class="form-control" type="username" id="usernameFieldLogIn" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="password" id="passwordFieldLogIn" placeholder="Password"></div>
            <div class="form-group"><a class="modalbutton" style="color:white; cursor:pointer;" onclick="UserLogin()">Log In</a></div>
            <a style="cursor: pointer;" onclick="SwitchLoginScreen(0)">New user? Sign up instead.</a><br>
            <a style="cursor: pointer;" onclick="SwitchLoginScreen(2)">I forgot my password.</a>
        </form>
    </div>

        <!-- The signup box -->
        <img id="loader" src="assets/img/loading.svg" />

    <div style="display: none;" id="signup-container" class="login-clean">
        <form style="text-align: center">
        <h3 style="margin-bottom: 20px;" >New user</h3>
            <div class="form-group"><input class="form-control" type="name" id="fnFieldSignUp" placeholder="First name"></div>
            <div class="form-group"><input class="form-control" type="name" id="lnFieldSignUp" placeholder="Surname"></div>
            <p style="margin-top:10px;margin-bottom:10px; text-align: left !important;"><strong>Birth date</strong></p>
            <div class="form-group"><input class="form-control" type="date" id="dateFieldSignUp" placeholder="Date of birth"></div>
            <div class="form-group"><input class="form-control" type="email" id="usernameFieldSignUp" placeholder="Username"></div>
            <div class="form-group"><input class="form-control" type="email" id="emailFieldSignUp" placeholder="Email"></div>
            <div class="form-group"><input class="form-control" type="password" id="passwordFieldSignUp" placeholder="Password"></div>
            <div class="form-group"><a class="modalbutton" style="cursor: pointer;"  style="color:white;" onclick="UserSignUp()">Sign up</a></div>
            <a style="cursor: pointer;" onclick="SwitchLoginScreen(1)">Returning user? Log in.</a><br>
            <a style="cursor: pointer;" onclick="SwitchLoginScreen(2)">I forgot my password.</a>
        </form>
    </div>

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
    <script src="assets/js/interaction.js"></script>
    <script src="assets/js/database.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
