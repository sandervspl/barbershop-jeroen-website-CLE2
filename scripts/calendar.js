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

function onTimeClick(time, etime) {
    if (time == 0 || etime == 0) return;

    window.sessionStorage.time = time;
    window.sessionStorage.end_time = etime;
    window.location.href = 'gegevens.php';
}