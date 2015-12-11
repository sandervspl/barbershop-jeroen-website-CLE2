<?php
/**
 * Created by PhpStorm.
 * User: Sandervspl
 * Date: 12/11/15
 * Time: 2:23 PM
 */

$ok = true;
if (!isset($_SESSION['barber']) || $_SESSION['barber'] === '') {
    $ok = false;
}
if (!isset($_SESSION['date']) || $_SESSION['date'] === '') {
    $ok = false;
}
if (!isset($_SESSION['time']) || $_SESSION['time'] === '') {
    $ok = false;
}
if (!isset($_SESSION['cut']) || $_SESSION['cut'] === '') {
    $ok = false;
}

