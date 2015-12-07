/**
 * Created by Sandervspl on 12/3/15.
 */


//change time information from date without reloading page (AJAX)
function showTimes(date, d, m, y) {
    if (date == "") {
        document.getElementById("times-table").innerHTML = "";
    } else {
        var xmlhttp;

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("times-table").innerHTML = xmlhttp.responseText;
            }
        };

        var url = "timestable.php?day=" + d + "&month=" + m + "&year=" + y;
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function onDateClick(d, mo, m, y) {
    date = d + "_" + m + "_" + y;
    showTimes(date, d, m, y);

    window.document.querySelector('#date-and-time-header').innerHTML = d + " " + mo + " " + y;
    window.document.getElementById('date-and-time-header').style.borderBottom = "1px solid black";

    b = window.document.getElementById('date-and-time-times-container');
    //b.style.visibility = "visible";
    b.style.height = "auto";

    // animate
    //$('date-and-time-times-container').animate({height:'300px'}, 5000, function() {});

    //window.location.href = 'booking.php?day=' + d + "&month=" + m + "&year=" + y;
}

function cutSelected() {
    var b = window.document.getElementById('cut');
    var i = window.document.getElementById('cut-time');

    // insert chosen cut type
    switch(window.sessionStorage.cut) {
        case "hair": {
            b.setAttribute('src', 'images/index/yes-hair-no-beard.png');
            i.setAttribute('src', 'images/booking/timer_30_min.png');
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "beard": {
            b.setAttribute('src', 'images/index/no-hair-yes-beard.png');
            i.setAttribute('src', 'images/booking/timer_30_min.png');
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "moustache": {
            b.setAttribute('src', 'images/index/no-hair-no-beard-yes-moustache.png');
            i.setAttribute('src', 'images/booking/timer_30_min.png');
            window.sessionStorage.cut_time = 30;
            break;
        }

        case "all": {
            b.setAttribute('src', 'images/index/yes-hair-yes-beard.png');
            i.setAttribute('src', 'images/booking/timer_45_min.png');
            window.sessionStorage.cut_time = 45;
            break;
        }

        default: {
            b.setAttribute('src', 'images/index/no-hair-no-beard.png');
            i.setAttribute('src', 'images/booking/timer_5_min.png');
            window.sessionStorage.cut_time = 5;
        }
    }
}

function barberSelected() {
    // insert chosen barber name
    window.document.querySelector('.barber-name').innerHTML = window.sessionStorage.barber;
}

function onTimeClick(time) {
    window.sessionStorage.time = time;
    window.location.href = 'gegevens.php';
}