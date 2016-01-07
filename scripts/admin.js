/**
 * Created by Sandervspl on 1/7/16.
 */

function timesContainerHover(sender) {
    var id = "p." + sender;
    document.getElementById(id).style.textDecoration = "none";

    id = "pp." + sender;
    document.getElementById(id).style.textDecoration = "none";
}

function timesContainerOut(sender) {
    var id = "p." + sender;
    document.getElementById(id).style.textDecoration = "line-through";

    id = "pp." + sender;
    document.getElementById(id).style.textDecoration = "line-through";
}