<?php

/**
 * Created by PhpStorm.
 * User: Sandervspl
 * Date: 1/19/16
 * Time: 1:14 PM
 */
class User
{
    private $host     = 'localhost';
    private $user     = 'root';
    private $pw       = '';
    private $database = 'website';

//        private $host     = 'localhost';
//        private $user     = '0832970';
//        private $pw       = 'voonaeci';
//        private $database = '0832970';


    private function dbconnect() {
        return mysqli_connect($this->host, $this->user, $this->pw, $this->database) or die('Error: ' . mysqli_connect_error());
    }

    // check if user is regular or admin
    function getUserLvl() {
        $db = mysqli_connect($this->host, $this->user, $this->pw, $this->database) or die('Error: ' . mysqli_connect_error());

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

            $stmt->close();
        }

        mysqli_close($db);

        return $lvl;
    }

    // get info like first and last name, email and phone number
    function getBasicUserInfo() {
        $userInfo = [];

        $db =  mysqli_connect($this->host, $this->user, $this->pw, $this->database) or die('Error: '.mysqli_connect_error());

        $sql = "SELECT
                  voornaam, achternaam, email, telefoon
                FROM
                  users
                WHERE
                  username = ?
                ";

        if ($stmt = $db->prepare($sql)) {
            $stmt->bind_param('s', $_SESSION['user']['username']);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($fvoornaam, $fachternaam, $femail, $ftelefoon);

                    while ($stmt->fetch()) {
                        $userInfo['voornaam']   = $fvoornaam;
                        $userInfo['achternaam'] = $fachternaam;
                        $userInfo['email']      = $femail;
                        $userInfo['telefoon']   = $ftelefoon;
                    }
                } else {
                    $stmt->close();
                    mysqli_close($db);

                    return 0;
                }
            }

            $stmt->close();
        }

        mysqli_close($db);

        return $userInfo;
    }
}