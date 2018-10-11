function UpdateUserToDatabase (id, fn, ln, g, dob) {
    console.log('trying to update');
    $.ajax({
         type: "POST",
         url: 'includes/updateUser.php',
         data: {
           id: id,
           fn: fn,
           ln: ln,
           g: g,
           dob: dob,
         },
         success:function(data) {
            if (data == 1) {
                //Alles is goed gegaan
                ShowNotiBox(3000, "User has been saved", true);
                RefreshUsers();
                CloseEdit();
            } else {
                //Er is een andere value dan 1 verkregen van de server, iets is er fout
                ShowNotiBox(3000, data, false);
            }
         }
    });
}

function AddLikeToDatabase (id) {
    $.ajax({
         type: "POST",
         url: 'includes/likePost.php',
         data: {
            likeId: id
         },
         success:function(data) {
                if (data != 0) {
                    if (data == 1) {
                        $('#likes'+id).text(data + " like");
                    } else if (data == 2) {
                        var oldLikeValue = $('#likes'+id).text();
                            $('#likes'+id).text("Already liked")
                            setTimeout(function () {
                                $('#likes'+id).text(oldLikeValue);
                        },1000);
                        $('#likes'+id).text("Already liked");
                    } else {
                        $('#likes'+id).text(data + " likes");
                    }
            } else {
                //Er is een andere value dan 1 verkregen van de server, iets is er fout
                ShowNotiBox(3000, data, false);
            }
         }
    });
}

function DeleteUserFromDatabase (id) {
    console.log('trying to delete');
    $.ajax({
         type: "POST",
         url: 'includes/deleteUser.php',
         data:{id: id},
         success:function(data) {
            if (data == 1) {
                //Alles is goed gegaan
                ShowNotiBox(3000, "User has been deleted", true);
                RefreshUsers();
            } else {
                //Er is een andere value dan 1 verkregen van de server, iets is er fout
                ShowNotiBox(3000, "Oops, something went wrong, user has not been deleted", false);
            }
        }
    });
}


function AddPostToDatabase(post) {

    $.ajax({
         type: "POST",
         url: 'includes/addPost.php',
         data:{
             post: post,
             color: RandomColor()
            },
         success:function(data) {
            if (data == 1) {
                //posts gedaan
                ShowNotiBox(1500, "Posted", true);
                if (window.location.pathname == "/social-globe/index.php") {
                    RefreshPosts();
                    ClearTextFields();
                    ClosePost();
                }
            } else {
                //De login was waarschijnlijk niet goed
                ShowNotiBox(1500, "Please try to log in again", false);
            }
        }, dataType: 'json'
    });
}

function AddChatToDatabase(message) {

    $.ajax({
         type: "POST",
         url: 'includes/sendChat.php',
         data:{
             message: message,
            },
         success:function(data) {
            if (data == 1) {
                //posts gedaan
                ClearTextFields();
            } else {
                //De login was waarschijnlijk niet goed
                ShowNotiBox(1500, "Please try again", false);
            }
        }, dataType: 'json'
    });
}


function VerifySignUpWithDatabase(fn, ln, dob, email, username, password) {
    $("#loader").toggle(300);

    $.ajax({
         type: "POST",
         url: 'includes/signUpUser.php',
         data:{
             fn: fn,
             ln: ln,
             dob: dob,
            username: username,
            email: email,
             password: password
            },
         success:function(data) {
            if (data == 1) {
                //Login in was goed
                ShowNotiBox(1500, "Signed up succesfully", true);
                $("#loader").toggle(300);
                setTimeout(function () {
                    window.location.href = "index.php";
                },2000);
            } else {
                //De login was waarschijnlijk niet goed
                $(".login-clean").show('fast');
                SwitchLoginScreen(0);
                ShowNotiBox(3000, data, false);
                $("#loader").toggle(300);
            }
        }
    });
}

function VerifyLoginWithDatabase (username, password) {
    console.log('trying to log in');
    $.ajax({
         type: "POST",
         url: 'includes/loginUser.php',
         data:{
            username: username,
            password: password
        },
         success:function(data) {
            if (data == 1) {
                //Login in was goed
                ShowNotiBox(1500, "Logged in succesfully", true);
                setTimeout(function () {
                    window.location.href = "index.php";
                },2000);
            } else {
                //De login was waarschijnlijk niet goed
                $(".login-clean").show('fast');
                SwitchLoginScreen(1);
                ShowNotiBox(3000, "Oops, some details are not quite right", false);
            }
        }
    });
}

function RefreshPosts() {


    $('#loader').fadeIn(200); // verstop de table
    $('#postContainer').hide('slow'); // verstop de table
    setTimeout(function () {
      $('#postContainer').empty(); // leeg de table
    },500)

    $.ajax({
        type: "POST",
        url: 'includes/refreshPosts.php',
        success:function(data) {
           if (data != null) {
            setTimeout(function () {
                $('#postContainer').append(data); // voeg de nieuwe data weer toe
                $('#postContainer').show('slow'); // laat dweer zien
                $('#loader').fadeOut(200); // verstop de table

            },500)
        } else {
            // er is iets fout gegaan
               ShowNotiBox(3000, "Oops, something went wrong, posts could not be fetched", false);
           }
        }
   });
}

function RefreshChat() {

    $.ajax({
        type: "POST",
        url: 'includes/refreshChat.php',
        success:function(data) {
           if (data != null) {
                $('.chat-messages').empty(); // voeg de nieuwe data weer toe
                $('.chat-messages').append(data); // voeg de nieuwe data weer toe
                scrollDown();
        } else {
            // er is iets fout gegaan
               ShowNotiBox(3000, "Oops, something went wrong, chat could not be fetched", false);
           }
        }
   });
}
//Image upload
$(document).ready(function (e) {
    $("#image-form").on('submit',(function(e) {
     e.preventDefault();
     $.ajax({
            url: "includes/imageUpload.php",
      type: "POST",
      data:  new FormData(this), // de data uit de form, het id en image
      contentType: false,
            cache: false,
      processData:false,
      beforeSend : function() {
        //Voorlopig niks
      },
      success: function(data)
         {
       if(data == 1) {
            //Upload compleet
            CloseModal();
            ShowNotiBox(1500, "Image is uploaded.", true);
            setTimeout(function () {
              location.reload();
            },1500)
            $("#image-form")[0].reset();


       }
       else {
            // Fout, de data laat zien wat er fout aan is
            ShowNotiBox(3000, data + ". Try again.", false);
       }
         },
        error: function(e) {
            // Een andere error, zal wss niet komen
            ShowNotiBox(3000, e + ". Try again.", false);
        }
       });
    }));
   });

   function GetProfileFromServer () {
    $('#profile-container').hide('fast'); // verstop de table
    setTimeout(function () {
      $('.profile-card').remove();
    },500)

    $.ajax({
        type: "POST",
            url: 'includes/loadProfile.php',
        success:function(data) {
           if (data != null) {
            setTimeout(function () {
                $('#profile-container').append(data); // voeg de nieuwe data weer toe
                $('#profile-container').show('fast'); // laat dweer zien
                $('#loader').fadeOut(200); // laat dweer zien
            },500)
        } else {
            // er is iets fout gegaan
               ShowNotiBox(3000, "Oops, something went wrong, profile could not be fetched", false);
           }
        }
   });
   }


   function GetUserProfile () {

    var params = new URLSearchParams(document.location.search.substring(1));
    var id = params.get("user_id");

    $('#profile-container').hide('fast');
    setTimeout(function () {
      $('.profile-card').remove();
    },500)

    $.ajax({
        type: "POST",
        url: 'includes/getUser.php',
        data: {
            user_id: id
        },
        success:function(data) {
           if (data != null) {
            setTimeout(function () {
                $('#profile-container').append(data); // voeg de nieuwe data weer toe
                $('#profile-container').show('fast'); // laat dweer zien
                $('#loader').fadeOut(200); // laat dweer zien
            },500)
        } else {
            // er is iets fout gegaan
               ShowNotiBox(3000, "Oops, something went wrong, profile could not be fetched", false);
           }
        }
   });
   }


   function ChangeProfile() {

       $.ajax({
            type: "POST",
            url: 'includes/updateUser.php',
            data:{
                fn: $("#editProfileFN").val(),
                ln: $("#editProfileLN").val(),
                u: $("#editProfileU").val()
               },
            success:function(data) {
               if (data == 1) {
                   //posts gedaan
                   ShowNotiBox(1500, "Profile has been updated", true);
                   $("#username").html($("#editProfileU").val());
                   $("#name").html($("#editProfileFN").val() + " " + $("#editProfileLN").val());
                   EditProfile();
               } else {
                   //De login was waarschijnlijk niet goed
                   ShowNotiBox(1500, "Please try again", false);
               }
           }, dataType: 'json'
       });
   }


   function VerifyEmail() {
    var params = new URLSearchParams(document.location.search.substring(1));
    var id = params.get("id");

    $.ajax({
        type: "POST",
        url: 'includes/verifyEmail.php',
        data:{
            id: id
           },
        success:function(data) {
           if (data == 1) {
               //posts gedaan
               ShowNotiBox(1500, "Email has been verified", true);
               setTimeout(function () {
                    window.location.href = "index.php";
                },2000);
           } else {
               //De login was waarschijnlijk niet goed
               ShowNotiBox(1500, "Verification token is not valid", false);
               setTimeout(function () {
                window.location.href = "resend-verification.php";
            },2000);
           }
       }, dataType: 'json'
   });

   }

   function ResendVerificationEmail() {

    $(".profile-card").toggle(300);
    $("#loader").toggle(300);
    $.ajax({
        type: "POST",
        url: 'includes/resendVerificationEmail.php',
        success:function(data) {
            console.log("WE HERE")
           if (data == 1) {
               //posts gedaan
               ShowNotiBox(3000, "A new verification email has been sent", true);
                $("#loader").toggle(300);
           } else {
               //De login was waarschijnlijk niet goed
               ShowNotiBox(2000, "Cannot send verification email, try again.", false);
               $(".profile-card").toggle(300);
                $("#loader").toggle(300);

           }
       }, dataType: 'json'
   });

   }


   function ResetPassword(type) {

    pass = "";
    username = "";
    reset_id = "";

    var params = new URLSearchParams(document.location.search.substring(1));
    var id = params.get("id");

    if (type == "reset") {
        $('#reset-container').hide(200);
        pass = $('#resetPasswordField').val();
        username = $('#resetUsernameField').val();
        reset_id = id;
        $("#loader").toggle(300);
    } else if (type == "email") {
        username = $('#resetUsernameField').val();
        $("#loader").toggle(300);
    } else if (type == "verify") {
        reset_id = id;
    }

    $.ajax({
        type: "POST",
        url: 'includes/passwordReset.php',
        data: {
            username: username,
            reset_id: reset_id,
            type: type,
            password: pass
        },
        success:function(data) {
            console.log(data)
           if (data == 1) {
               //posts gedaan
               ShowNotiBox(3000, "An email has been sent to reset the password", true);
                $("#loader").toggle(300);
           } else if (data == 2) {
                ShowNotiBox(1500, "Password has been reset", true);
                setTimeout(function () {
                    window.location.href = "login.php";
                },2000);
           } else {
               //De login was waarschijnlijk niet goed
               ShowNotiBox(2000, "Cannot reset, try again.", false);
                $('#reset-container').show(200);
                $("#loader").toggle(300);

           }
       }, dataType: 'json'
   });

   }


   function FollowUser (username) {
    console.log('trying to add friend');
    $.ajax({
         type: "POST",
         url: 'includes/followUser.php',
         data:{
            username: username
        },
         success:function(data) {
            if (data == 1) { // 1 is a public account
                ShowNotiBox(2000, `You are now following ${username}`, true);
                $('.following').text("Following");
            } else if (data == 2) {
                ShowNotiBox(2500, `You have requested to follow ${username}`, true);
                $('.following').text("Requested to follow");
            } else if (data == 3) {
                ShowNotiBox(2500, `You are already following ${username}`, false);
                $('.following').text("Following");
            } else if (data == 4) {
                ShowNotiBox(5000, `Trying to follow yourself? Don't worry it's okay to be lonely.`, false);
                $('.following').text();
            } else {
                ShowNotiBox(3000, `Oops, could not follow ${username} at this time`, false);
            }
            setTimeout(function () {
              location.reload();
            },1000)
        }, dataType: 'json'
    });
}

function UnfollowUser (username) {
 console.log('trying to add friend');
 $.ajax({
      type: "POST",
      url: 'includes/unfollowUser.php',
      data:{
         username: username
     },
      success:function(data) {
        console.log(data);
         if (data == 1) { // 1 is a public account
             ShowNotiBox(2000, `You unfollowed ${username}`, true);
             $('.following').text("Unfollowed");
         } else if (data == 2) {
             ShowNotiBox(2500, `You have requested to follow ${username}`, true);
         } else if (data == 3) {
             ShowNotiBox(2500, `You are already following ${username}`, false);
         } else if (data == 4) {
             ShowNotiBox(5000, `Trying to follow yourself? Don't worry it's okay to be lonely.`, false);
         } else {
             ShowNotiBox(3000, `Oops, could not follow ${username} at this time`, false);
         }

         setTimeout(function () {
           location.reload();
         },1000)
     }, dataType: 'json'
 });
}
