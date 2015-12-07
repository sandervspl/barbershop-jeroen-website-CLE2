/**
 * Created by Sandervspl on 12/3/15.
 */

function onDateClick(d, m, y) {
    window.document.querySelector('#date-and-time-header').innerHTML = d + " " + m + " " + y;
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