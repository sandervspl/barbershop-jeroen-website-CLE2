/**
 * Created by Sandervspl on 12/2/15.
 */

function userInfoHover(sender) {
    document.getElementById(sender).style.backgroundColor = "rgba(0, 0, 0, 0.064)";

    var list1 = Array.prototype.slice.call(document.getElementById(sender).getElementsByClassName("header-text-small appointment-title appointment-past")),
        list2 = Array.prototype.slice.call(document.getElementById(sender).getElementsByClassName("header-text-small appointment-value appointment-past"));

    var divList = list1.concat(list2);

    for (var i = 0; i < divList.length; i++) {
        divList[i].style.textDecoration = "none";
        divList[i].style.color = "black";
    }
}

function userInfoOut(sender) {
    document.getElementById(sender).style.backgroundColor = "rgba(0, 0, 0, 0.024)";

    var list1 = Array.prototype.slice.call(document.getElementById(sender).getElementsByClassName("header-text-small appointment-title appointment-past")),
        list2 = Array.prototype.slice.call(document.getElementById(sender).getElementsByClassName("header-text-small appointment-value appointment-past"));

    var divList = list1.concat(list2);

    for (i = 0; i < divList.length; i++) {
        divList[i].style.textDecoration = "line-through";
        divList[i].style.color = "#b2b2b2";
    }
}



function lockButton(id) {
    if (window.document.getElementById(id)) {
        window.document.getElementById(id).disabled = true;
    }
}

function unlockButton() {
    if (window.sessionStorage.cut != 0) {
        if(window.document.getElementById("bookButton")) {
            window.document.getElementById("bookButton").disabled = false;
        }
    }
}



function cutSelect(sender) {
    window.sessionStorage.cut = sender.id;

    unlockButton();
}

function barberSelection(sender) {
    window.sessionStorage.barber = sender.id;
}

// insert chosen cut type chosen by user
function cutSelected() {
    var b = window.document.getElementById('cut');
    var cutTime = 0;

    if (window.document.getElementById('cut-time')) {
        cutTime = window.document.getElementById('cut-time');
    }

    switch(window.sessionStorage.cut) {
        case "hair": {
            b.setAttribute('src', 'images/index/yes-hair-no-beard.png');
            if (cutTime) {
                cutTime.setAttribute('src', 'images/booking/timer_30_min.png');
                window.document.getElementById('cut-time-text').innerHTML = "30 minuten";
            }
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "beard": {
            b.setAttribute('src', 'images/index/no-hair-yes-beard.png');
            if (cutTime) {
                cutTime.setAttribute('src', 'images/booking/timer_30_min.png');
                window.document.getElementById('cut-time-text').innerHTML = "30 minuten";
            }
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "moustache": {
            b.setAttribute('src', 'images/index/no-hair-no-beard-yes-moustache.png');
            if (cutTime) {
                cutTime.setAttribute('src', 'images/booking/timer_30_min.png');
                window.document.getElementById('cut-time-text').innerHTML = "30 minuten";
            }
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "all": {
            b.setAttribute('src', 'images/index/yes-hair-yes-beard.png');
            if (cutTime) {
                cutTime.setAttribute('src', 'images/booking/timer_60_min.png');
                window.document.getElementById('cut-time-text').innerHTML = "60 minuten";
            }
            window.sessionStorage.cut_time = 60;
            break;
        }

        default: {
            b.setAttribute('src', 'images/index/no-hair-no-beard.png');
            if (cutTime) cutTime.setAttribute('src', 'images/booking/timer_clear.png');
            window.sessionStorage.cut_time = 5;
        }
    }
}

// insert saved time chosen by user
function timeSelected() {
    window.document.querySelector('#chosen-time').innerHTML = window.sessionStorage.time;
    window.document.querySelector('#chosen-etime').innerHTML = window.sessionStorage.end_time;
}

function monthSelected() {
    window.document.querySelector('#chosen-month').innerHTML = window.sessionStorage.monthday + " " + window.sessionStorage.month;
}


function checkBookButton() {
    if (window.sessionStorage.cut == 0) {
        alert("Kies een kapper en/of wat je gedaan wilt hebben tijdens jouw afspraak.");
    } else {
        window.location.href = 'booking.php';
    }
}




// getters
function getBarber() {
    return window.sessionStorage.barber;
}

function getTime() {
    return window.sessionStorage.time;
}