/**
 * Created by Sandervspl on 12/21/15.
 */

function validateUsername(id) {
    var regex = /[A-Za-z -_]$/;

    if (regex.test(document.getElementById(id).value)) {
        document.getElementById(id).style.background = '#ccffcc';
        //document.getElementById(id + 'Error').style.display = "none";
        document.getElementById(id + 'Error').style.visibility = "hidden";
        return true;
    } else {
        document.getElementById(id).style.background = '#e35152';
        //document.getElementById(id + 'Error').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        return false;
    }
}

function validateNaam(id) {
    var regex = /[A-Za-z -']$/;

    if (regex.test(document.getElementById(id).value)) {
        document.getElementById(id).style.background = '#ccffcc';
        //document.getElementById(id + 'Error').style.display = "none";
        document.getElementById(id + 'Error').style.visibility = "hidden";
        return true;
    } else {
        document.getElementById(id).style.background = '#e35152';
        //document.getElementById(id + 'Error').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        return false;
    }
}

function validateEmail(id) {
    var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (regex.test(document.getElementById(id).value)) {
        document.getElementById(id).style.background = '#ccffcc';
        //document.getElementById(id + 'Error').style.display = "none";
        document.getElementById(id + 'Error').style.visibility = "hidden";
        return true;
    } else {
        document.getElementById('email').style.background = '#e35152';
        //document.getElementById(id + 'Error').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        return false;
    }
}

function validatePassword(id) {
    var regex = /^\S{5,24}$/;

    if (password == "") {
        document.getElementById(id).style.background = '#e35152';
        //document.getElementById(id + 'Error').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "hidden";
        return false;
    }

    if (regex.test(document.getElementById(id).value)) {
        document.getElementById(id).style.background = '#ccffcc';
        //document.getElementById(id + 'Error').style.display = "none";
        document.getElementById(id + 'Error').style.visibility = "hidden";
        return true;
    } else {
        document.getElementById(id).style.background = '#e35152';
        //document.getElementById(id + 'Error').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        return false;
    }
}

function validateTelefoon(id) {
    var regex = /^[0-9]{9,20}$/;

    if (regex.test(document.getElementById(id).value)) {
        document.getElementById(id).style.background = '#ccffcc';
        //document.getElementById(id + 'Error').style.display = "none";
        document.getElementById(id + 'Error').style.visibility = "hidden";
        return true;
    } else {
        document.getElementById(id).style.background = '#e35152';
        //document.getElementById(id + 'Error').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        return false;
    }
}

function validateForm() {
    var errors = 0;

    if (!validateUsername('username')) {
        //document.getElementById('usernameError').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        errors++;
    }
    if (!validateNaam('voornaam')) {
        //document.getElementById('voornaamError').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        errors++;
    }
    if (!validateNaam('achternaam')) {
        //document.getElementById('achternaamError').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        errors++;
    }
    if (!validateEmail('email')) {
        errors++;
    }
    if (!validatePassword('telefoon')) {
        //document.getElementById('telefoonError').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        errors++;
    }
    if (!validatePassword('password')) {
        //document.getElementById('passwordError').style.display = "block";
        document.getElementById(id + 'Error').style.visibility = "visible";
        errors++;
    }

    if (errors > 0) {
        return false;
    }
}

function setInputFalse(id) {
    document.getElementById(id).style.background = '#e35152';
}