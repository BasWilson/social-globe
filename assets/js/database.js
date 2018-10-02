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


function VerifySignUpWithDatabase(fn, ln, dob, email, password) {

    $.ajax({
         type: "POST",
         url: 'includes/signUpUser.php',
         data:{
             fn: fn,
             ln: ln,
             dob: dob,
             email: email,
             password: password
            },
         success:function(data) {
            if (data == 1) {
                //Login in was goed
                ShowNotiBox(1500, "Signed up succesfully", true);
                setTimeout(function () {
                    window.location.href = "index.php";
                },2000);
            } else {
                //De login was waarschijnlijk niet goed
                $(".login-clean").show('fast');
                SwitchLoginScreen(0);
                ShowNotiBox(3000, data, false);
            }
        }
    });
}

function VerifyLoginWithDatabase (email, password) {
    console.log('trying to log in');
    $.ajax({
         type: "POST",
         url: 'includes/loginUser.php',
         data:{
            email: email,
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


   function ChangeProfile(post) {

       $.ajax({
            type: "POST",
            url: 'includes/changeProfile.php',
            data:{
                post: post
               },
            success:function(data) {
               if (data == 1) {
                   //posts gedaan
                   ShowNotiBox(1500, "Posted", true);
                   if (window.location.pathname == "/social-globe/profile.php") {
                   }
               } else {
                   //De login was waarschijnlijk niet goed
                   ShowNotiBox(1500, "Please try to log in again", false);
               }
           }, dataType: 'json'
       });
   }
