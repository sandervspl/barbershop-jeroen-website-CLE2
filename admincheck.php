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

    $sql = "SELECT
              level
            FROM
              users
            WHERE
              username = ?
           ";

    $lvl = 0;
    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('s', $_SESSION['user']['username']);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($userlevel);

            while ($stmt->fetch()) {
                $lvl = $userlevel;
            }
        }
    }
    mysqli_close($db);

    return $lvl;
}