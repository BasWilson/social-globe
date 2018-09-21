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

function VerifySignUpWithDatabase(fn, ln, dob, gender, email, password) {
    console.log('trying to add');
    
    $.ajax({
         type: "POST",
         url: 'includes/signUpUser.php',
         data:{
             fn: fn,
             ln: ln,
             dob: dob,
             gender: gender,
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

function RefreshUsers() {

    $('.table').hide('slow'); // verstop de table
    $('#users-data').empty(); // leeg de table

    $.ajax({
        type: "POST",
        url: 'includes/refreshUsers.php',
        data: {
            sortBy: $('#sortField').val() // de waarde van de dropdown
        },
        success:function(data) {
           if (data != null) {
            $('#users-data').append(data); // voeg de nieuwe data weer toe
            setTimeout(function () {
                $('.table').show('slow'); // laat dweer zien
            },500)
        } else {
            // er is iets fout gegaan
               ShowNotiBox(3000, "Oops, something went wrong, user data could not be fetched", false);
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
            ShowNotiBox(3000, "Image is uploaded.", true);
            RefreshUsers();
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