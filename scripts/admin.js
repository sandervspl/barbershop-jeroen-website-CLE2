/**
 * Created by Sandervspl on 1/7/16.
 */

function timesContainerHover(sender) {
    var list1 = Array.prototype.slice.call(document.getElementById(sender).getElementsByClassName("time-user-info-past"));
    var list2 = Array.prototype.slice.call(document.getElementById(sender).getElementsByClassName("time-button-taken"));
    var list = list1.concat(list2);

    for (var i = 0; i < list.length; i++) {
        list[i].style.textDecoration = "none";
        list[i].style.color = "black";
    }

    var list3 = document.getElementById(sender).getElementsByClassName("admin-times-img times-icon-taken");
    for (i = 0; i < list3.length; i++) {
        list3[i].setAttribute('src', 'images/booking/timer_clear2.png');
    }
}

function timesContainerOut(sender) {
    var list = document.getElementById(sender).getElementsByClassName("time-user-info-past");
    var list2 = document.getElementById(sender).getElementsByClassName("time-button-taken");

    for (i = 0; i < list2.length; i++) {
        list2[i].style.color = "#b2b2b2";
    }

    for (var i = 0; i < list.length; i++) {
        list[i].style.textDecoration = "line-through";
        list[i].style.color = "#b2b2b2";
    }

    // get original img src and go back to it
    var res = sender.split("|");
    var imgsrc = res[1];

    var list3 = document.getElementById(sender).getElementsByClassName("admin-times-img times-icon-taken");
    for (i = 0; i < list3.length; i++) {
        list3[i].setAttribute('src', imgsrc);
    }
}