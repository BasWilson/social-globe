//Veel elementen
const editContainer = document.getElementById('edit-container');
const userId = document.getElementById('user-id');

var firstNameField = document.getElementById('first_name_field');
var lastNameField = document.getElementById('last_name_field');
var genderField = document.getElementById('gender_field');
var dateField = document.getElementById('date_field');

var sinceText = document.getElementById('since-text');
var idText = document.getElementById('id-text');

//modal
var modal = document.getElementById('modal-popup');
var modalText = document.getElementById('modal-text');
var closeModalBtn = document.getElementsByClassName("close")[0];

var confirmFn = document.getElementById('confirm-fn');
var confirmLn = document.getElementById('confirm-ln');
var confirmG = document.getElementById('confirm-g');
var confirmDob = document.getElementById('confirm-dob');

//Notibox
var notiText = document.getElementById('noti-text');
var notiBox = document.getElementById('noti-box');

var fn, ln, g, dob, since;

var selectedID = -1; // het geseleceteerde id van de user
var selectedImageID = -1; // ˆˆ
var chatOpen = false;
var chatInterval;
//Opent de New user menu
function OpenNewPost () {

    selectedID = -1;
    $('#add-container').show("fast");
    $('#bubbleColorField').val((Math.random()*0xFFFFFF<<0).toString(16));
}

function SwitchLoginScreen(currentLoginScreen) {
    if (currentLoginScreen == 0) {
        $('#login-container').hide("fast");
        $('#signup-container').show("fast");
    } else {
        $('#login-container').show("fast");
        $('#signup-container').hide("fast");
    }

}
//Edit een user door op de edit knop te kliken
function EditUser(id) {

    selectedID = id;

    console.log("Editing user: " + id)

    $('#edit-container').show("fast");
    $('#add-container').hide("fast");

    userId.innerHTML = "Editing user " + id;

    //Haal deze gebruikers details op uit de HTML
    fn = $('#'+id).closest("tr").find(".first-name").text();
    ln = $('#'+id).closest("tr").find(".last-name").text();
    g = $('#'+id).closest("tr").find(".gender").text();
    dob = $('#'+id).closest("tr").find(".birth-date").text();
    since = $('#'+id).closest("tr").find(".member-since").text();

    //Changeable values
    firstNameField.value = fn;
    lastNameField.value = ln;
    dateField.value = dob;

    //Non-editable values
    sinceText.innerHTML = since;
    idText.innerHTML = id;

    if (g == "M") {
        document.getElementById('male-option').selected = true
    } else if (g == "F") {
        document.getElementById('female-option').selected = true
    } else {
        document.getElementById('male-option').selected = true
    }

    //Scroll naar boven
    window.scrollTo(0, 0);

}

function SaveUser() {

    //Vraag de gebruiker of alle veranderingen kloppen en laat het verschil ook zien
    $('#confirm-fn').show();
    $('#confirm-ln').show();
    $('#confirm-g').show();
    $('#confirm-dob').show();
    $('#confirmSaveBtn').show();
    $('#confirmDelBtn').hide();

    modalText.innerHTML = "Are you sure you want save these changes?";
    $('#confirm-fn').html('First name from <strong>'+fn+'</strong> to <strong>'+ firstNameField.value +'</strong>');
    $('#confirm-ln').html('Last name from <strong>'+ln+'</strong> to <strong>'+ lastNameField.value +'</strong>');
    $('#confirm-g').html('Gender from <strong>'+g+'</strong> to <strong>'+ genderField.value +'</strong>');
    $('#confirm-dob').html('Date of birth from <strong>'+dob+'</strong> to <strong>'+ dateField.value +'</strong>');
    OpenModal();

}

function ConfirmSave() {

    //Sla het op en verstuur de aanvraag naar de server dmv ajax
    console.log("Saving user: " + selectedID)

    UpdateUserToDatabase(selectedID, firstNameField.value, lastNameField.value, genderField.value, dateField.value);

    CloseModal();

}

function DeleteUser(id) {

    //Laat de user zien wat hij delete

    fn = $('#'+id).closest("tr").find(".first-name").text();
    ln = $('#'+id).closest("tr").find(".last-name").text();
    g = $('#'+id).closest("tr").find(".gender").text();
    dob = $('#'+id).closest("tr").find(".birth-date").text();
    since = $('#'+id).closest("tr").find(".member-since").text();

    selectedID = id;

    modalText.innerHTML = "Are you sure you want to delete this user?";
    $('#confirm-fn').html('<strong>'+fn+' '+ln+'</strong>');
    $('#confirm-fn').show();
    $('#confirmSaveBtn').hide();
    $('#confirmDelBtn').show();
    $('#confirm-ln').hide();
    $('#confirm-g').hide();
    $('#confirm-dob').hide();
    OpenModal();

}

function ConfirmDelete() {

    // Verstuur door via ajax.
    console.log("Deleting user: " + selectedID)

    DeleteUserFromDatabase(selectedID);

    CloseEdit();
    CloseModal();

}

function CloseEdit() {

    selectedID = -1;

    $('#edit-container').hide("fast");

}

function ClosePost() {

    selectedID = -1;

    $('#add-container').hide("fast");

}


function CloseAddUser() {

    $('#add-container').hide("fast");

}

function OpenModal () {

    $('.modal').show();
    $('.modal-content').show("fast");

}

function OpenHelpModal () {

    $('.help-modal').show();
    $('.help-modal-content').show("fast");

}

function CloseModal () {

    $('.modal').hide("fast");
    $('.image-modal').hide("fast");
    $('.help-modal').hide("fast");
    $('.modal-content').hide("fast");
    $('.image-modal-content').hide("fast");
    $('.help-modal-content').hide("fast");

}

function ShowNotiBox (duration, text, status) {

    //Het rode of groene boxje dat je af en toe ziet verschijnen
    notiText.innerHTML = text;

    //True is groen, false is rood
    if (status) {
        notiBox.style.backgroundColor = "rgba(0, 255, 0, 0.5)";
    } else {
        notiBox.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
    }
    $('.noti-box').show("fast");

    //Als de opgegeven duration minder dan 1000ms of groter dan 5000ms is of geen waarde is dan word het 3000ms
    if (duration > 5000 || duration == null || duration < 1000) {
        duration = 3000
    }

    //Stel de tijd in in ms dat het boxje er moet blijven dmv de setTimeout functie.
    setTimeout(function () {
        notiText.innerHTML = "";
        $('.noti-box').hide("fast");
    }, duration)

}

function UserLogin() {

    //Log in aanvraag via ajax versturen
    let e = document.getElementById('emailFieldLogIn').value;
    let p = document.getElementById('passwordFieldLogIn').value;
    if (e != "" && p != "") {
        //Fields are not empty, allow login
        VerifyLoginWithDatabase(e, p);
        $(".login-clean").hide('fast');
    } else {
        $(".login-clean").show('fast');
        ShowNotiBox(3000, "Please fill in all fields", false);
    }

}

function UserSignUp() {

    let fn = document.getElementById('fnFieldSignUp').value;
    let ln = document.getElementById('lnFieldSignUp').value;
    let dob = document.getElementById('dateFieldSignUp').value;
    let email = document.getElementById('emailFieldSignUp').value;
    let password = document.getElementById('passwordFieldSignUp').value;

    if (fn != "" && ln != "" && dob != "" && email != "" && password != "") {
        //User toeveoegen via ajax
        VerifySignUpWithDatabase(fn, ln, dob, email, password);
        $(".login-clean").hide('fast');
    } else {
        SwitchLoginScreen(0);
        ShowNotiBox(3000, "Please fill in all fields", false);
    }


}

function AddPost() {

    let post = document.getElementById('textField').value;

    if (post != "") {
        AddPostToDatabase(post);
    }
}

function ClearTextFields() {
    //alle add user fields legen
    document.getElementById('textField').value = "";
    document.getElementById('chat-text-field').value = "";
}

function OpenImageUpload (id) {

    //open de image modal
    selectedImageID = id;
    var img = document.getElementById(id+'img').src;
    document.getElementById('modal-image').src = img;
    document.getElementById('pic-id').value = id;

    OpenImageModal();

}

function OpenImageModal () {

    $('.image-modal').show();
    $('.image-modal-content').show("fast");

}

//luiste voor de onclick op de close button van de modal
closeModalBtn.onclick = function() {
    $('.modal').hide("fast");
    $('.image-modal').hide("fast");
    $('.modal-content').hide("fast");
    $('.image-modal-content').hide("fast");
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        modal.style.display = "none";
    }
}

function RandomColor () {
    let color = "rgba("+ getRandomInt(255) + "," + getRandomInt(255) + "," + getRandomInt(255) + ", ";
    return color;
}
function hexToRgbA(hex){
    var c;
    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
        c= hex.substring(1).split('');
        if(c.length== 3){
            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c= '0x'+c.join('');
        return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',';
    }
    throw new Error('Bad Hex');
}

function LikePost(id) {
    AddLikeToDatabase(id);
}

function getRandomInt(max) {
  return Math.floor(Math.random() * Math.floor(max));
}

function GetProfile() {
    $('#loader').show(200);
    GetProfileFromServer();
}

function ToggleChat () {
    $('.chat-container').toggle('fast');
    if (chatOpen) {
        $('.chat-button-image').attr("src", "assets/img/chat.png");
        chatOpen = false;
        clearInterval(chatInterval);
    } else {
        $('.chat-button-image').attr("src", "assets/img/cross.png");
        chatOpen = true;
        chatInterval = setInterval(function () {
            RefreshChat();
        },100)
    }
}

function SendChatMessage () {
    if ($('#chat-text-field').val() != "") {
        AddChatToDatabase($('#chat-text-field').val());
    }  else {
        ShowNotiBox(1500,"Enter a message", false);
    }
}

function scrollDown() {
    $('.chat-messages').animate({
    scrollTop: $('.chat-messages').get(0).scrollHeight}, 100);
  }

//enter bij de chatroom
  document.getElementById('chat-text-field').addEventListener('keypress', function(event) {
      if (event.keyCode == 13) {
          event.preventDefault();
          SendChatMessage();

      }
  });

//enter bij de posts
document.getElementById('textField').addEventListener('keypress', function(event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        AddPost();

    }
});
<<<<<<< HEAD
<<<<<<< HEAD


//profile aanpassen
function EditProfile(){
$('.profile-edit-change').hide(200);
document.getElementById('profile-edit1-change').style.display = "block";

}
=======
>>>>>>> parent of 3728d6b... dingen gefixt alleen de php profile werkt niet geen idee wat er fout is
=======
>>>>>>> parent of 3728d6b... dingen gefixt alleen de php profile werkt niet geen idee wat er fout is
