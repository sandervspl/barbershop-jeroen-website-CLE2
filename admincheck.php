<?php
/**
 * Created by PhpStorm.
 * User: Sandervspl
 * Date: 1/6/16
 * Time: 8:40 PM
 */

function isAdmin()
{
    $host     = 'localhost';
    $user     = 'root';
    $pw       = '';
    $database = 'website';

    $db = mysqli_connect($host, $user, $pw, $database) or die('Error: ' . mysqli_connect_error());

    $sql = sprintf("SELECT level FROM users WHERE username='%s'", $_SESSION['user']['username']);

    $result = mysqli_query($db, $sql);
    $re = mysqli_fetch_row($result);

    if ($re[0] != 1) {
        $result = false;
    } else {
        $result = true;
    }

    mysqli_close($db);

    return $result;
}