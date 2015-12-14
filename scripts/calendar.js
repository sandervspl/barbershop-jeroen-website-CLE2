/**
 * Created by Sandervspl on 12/3/15.
 */

function loadCalendar(m, y) {
    var xmlhttp;

    document.getElementById("calendar-table").innerHTML = "<img class=\"loading-gif\" src=\"http://www.jasonkenison.com/uploads/blog/loading.gif\" />";

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("calendar-table").innerHTML = xmlhttp.responseText;
        }
    };

    var url = "calendar.php?month=" + m + "&year=" + y;
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

function getMonth(m) {
    var month = new Array(13);
    month[1] = "Januari";
    month[2] = "Februari";
    month[3] = "Maart";
    month[4] = "April";
    month[5] = "Mei";
    month[6] = "Juni";
    month[7] = "Juli";
    month[8] = "Augustus";
    month[9] = "September";
    month[10] = "Oktober";
    month[11] = "November";
    month[12] = "December";
    return month[m];
}

function nextMonth(sender, m, y) {
    if (sender.src.includes("images/booking/calendar_left.png")) {
        sender.setAttribute('src', 'images/booking/calendar_right.png');
    } else {
        sender.setAttribute('src', 'images/booking/calendar_left.png');

        m++;
        if (m > 12) {
            m = 1;
            y++;
        }
    }

    window.document.getElementById('calendar-header-text').innerHTML = getMonth(m);

    loadCalendar(m, y);
}

//change time information from date without reloading page (AJAX)
function showTimes(date, d, m, y) {
    if (date == "") {
        document.getElementById("times-table").innerHTML = "";
    } else {
        var xmlhttp;

        document.getElementById("main-page").style.minHeight = "1200px";
        document.getElementById("times-table").innerHTML = '<img class="loading-gif" src="http://www.jasonkenison.com/uploads/blog/loading.gif" />';

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("times-table").innerHTML = xmlhttp.responseText;
            }
        };

        var url = "timestable.php?day=" + d + "&month=" + m + "&year=" + y;
        xmlhttp.open("GET", url, true);
        xmlhttp.send();
    }
}

function onDateClick(d, da, mo, m, y) {
    date = d + "_" + m + "_" + y;
    showTimes(date, d, m, y);

    window.document.querySelector('#date-and-time-header').innerHTML = "<p class='header-text-small'>" + da + "</p>" + d + " " + mo + " " + y;
    window.document.getElementById('date-and-time-header').style.borderBottom = "1px solid black";

    b = window.document.getElementById('date-and-time-times-container');
    //b.style.visibility = "visible";
    b.style.height = "auto";

    window.sessionStorage.monthday = d;

    // animate
    //$('date-and-time-times-container').animate({height:'300px'}, 5000, function() {});

    //window.location.href = 'booking.php?day=' + d + "&month=" + m + "&year=" + y;
}

function onTimeClick(time, etime, month) {
    if (time == 0 || etime == 0) return;

    window.sessionStorage.time = time;
    window.sessionStorage.end_time = etime;
    window.sessionStorage.month = month;
}