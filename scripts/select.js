/**
 * Created by Sandervspl on 12/2/15.
 */

//function writeCookie(name,value,days) {
//    var date, expires;
//    if (days) {
//        date = new Date();
//        date.setTime(date.getTime()+(days*24*60*60*1000));
//        expires = "; expires=" + date.toGMTString();
//    } else {
//        expires = "";
//    }
//
//    document.cookie = name + "=" + value + expires + "; path=/";
//}

function cutSelect(sender) {
    // loop through our UL to check if any other img files are set as selected
    var a_elements = sender.parentNode.parentNode.getElementsByTagName("img");

    for (var i = 0, len = a_elements.length; i < len; i++) {
        var str = a_elements[i].getAttribute('src');
        var src = str.replace("-selected.png", ".png");
        a_elements[i].setAttribute('src', src);
    }

    // set sender as selected
    var img = sender.getAttribute('src');
    src = img.replace(".png", "-selected.png");
    sender.setAttribute('src', src);

    window.sessionStorage.cut = sender.id;
}

function barberSelection(sender) {
    // loop through our UL to check if any other name is selected
    var a_elements = sender.parentNode.parentNode.getElementsByTagName("label");

    for (var i = 0, len = a_elements.length; i < len; i++) {
        a_elements[i].style.color = '#000000';
        a_elements[i].style.border = '2px solid #000000';
    }

    // set sender as selected
    sender.style.color = 'white';
    sender.style.border = '2px solid white';

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
            if (cutTime) cutTime.setAttribute('src', 'images/booking/timer_30_min.png');
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "beard": {
            b.setAttribute('src', 'images/index/no-hair-yes-beard.png');
            if (cutTime) cutTime.setAttribute('src', 'images/booking/timer_30_min.png');
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "moustache": {
            b.setAttribute('src', 'images/index/no-hair-no-beard-yes-moustache.png');
            if (cutTime) cutTime.setAttribute('src', 'images/booking/timer_30_min.png');
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "all": {
            b.setAttribute('src', 'images/index/yes-hair-yes-beard.png');
            if (cutTime) cutTime.setAttribute('src', 'images/booking/timer_45_min.png');
            window.sessionStorage.cut_time = 45;
            break;
        }

        default: {
            b.setAttribute('src', 'images/index/no-hair-no-beard.png');
            if (cutTime) cutTime.setAttribute('src', 'images/booking/timer_clear.png');
            window.sessionStorage.cut_time = 5;
        }
    }
}

// insert saved barber name chosen by user
function barberSelected() {
    window.document.querySelector('.barber-name').innerHTML = window.sessionStorage.barber;
}

// insert saved time chosen by user
function timeSelected() {
    window.document.querySelector('#chosen-time').innerHTML = window.sessionStorage.time;
    window.document.querySelector('#chosen-etime').innerHTML = window.sessionStorage.end_time;
}


function checkBookButton() {
    if (window.sessionStorage.cut == 0 || window.sessionStorage.barber == 0) {
        alert("Kies een kapper en/of wat je gedaan wilt hebben tijdens jouw afspraak.");
    } else {
        //sender.style.color = 'white';
        //sender.style.border = '2px solid white';

        window.location.href = 'booking.php';
    }
}