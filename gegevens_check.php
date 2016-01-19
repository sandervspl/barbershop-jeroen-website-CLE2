<?php
if(!isset($_SESSION)) {
    session_start();
}

// database connection information
require_once "connect.php";
require_once "User.php";

$barber = '';
$date = '';
$time = '';
$cut = '';
$email = '';
$voornaam = '';
$achternaam = '';
$phone = '';

$ok = true;

// prioritize login session's data for name, e-mail and phone
if (isset($_SESSION['user']['username'])) {

    $user_ = new User;

    $userInfo = $user_->getBasicUserInfo();

    if ($userInfo == 0) {
        $ok = false;
    } else {
        $voornaam   = $userInfo['voornaam'];
        $achternaam = $userInfo['achternaam'];
        $email      = $userInfo['email'];
        $phone      = $userInfo['telefoon'];
    }
} else {
    if (!isset($_POST['voornaam']) || $_POST['voornaam'] === '') {
        $ok = false;
        echo "Error: VOORNAAM variable is not set. ";
    } else {
        $voornaam = $_POST['voornaam'];
    }
    if (!isset($_POST['achternaam']) || $_POST['achternaam'] === '') {
        $ok = false;
    } else {
        $achternaam = $_POST['achternaam'];
    }
    if (!isset($_POST['email']) || $_POST['email'] === '') {
        $ok = false;
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $ok = false;
        } else {
            $email = $_POST['email'];
        }
    }
    if (!isset($_POST['phone']) || $_POST['phone'] === '') {
        $ok = false;
    } else {
        if (!preg_match("/[0-9]{10}/", $_POST['phone'])) {
            $ok = false;
        }
        $phone = $_POST['phone'];
    }
}


// barber, cut, date, time data
if (!isset($_SESSION['barber']) || $_SESSION['barber'] === '') {
    $ok = false;

    header("Location: error.php");
    die("Redirecting to error.php");
} else {
    $barber = $_SESSION['barber'];
}
if (!isset($_SESSION['date']) || $_SESSION['date'] === '') {
    $ok = false;

    header("Location: error.php");
    die("Redirecting to error.php");
} else {
    $date = $_SESSION['date'];
}
if (!isset($_SESSION['time']) || $_SESSION['time'] === '') {
    $ok = false;

    header("Location: error.php");
    die("Redirecting to error.php");
} else {
    $time = $_SESSION['time'];
}
if (!isset($_SESSION['cut']) || $_SESSION['cut'] === '') {
    $ok = false;

    header("Location: error.php");
    die("Redirecting to error.php");
} else {
    $cut = $_SESSION['cut'];
}


$db =  mysqli_connect($host, $user, $pw, $database) or die('Error: '.mysqli_connect_error());

$sql = "SELECT
          1
        FROM
          afspraken
        WHERE
          datum = ?
        AND
          tijd = ?
        AND
          kapper = ?
       ";

if ($stmt = $db->prepare($sql)) {
    $stmt->bind_param('sss', $_SESSION['date'], $_SESSION['time'], $_SESSION['barber']);

    if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $ok = false;
        }
    }

    $stmt->close();
}

mysqli_close($db);


if ($ok) {
    // add to db
    $db = mysqli_connect($host, $user, $pw, $database) or die('Error: '.mysqli_connect_error());

    $sql = "INSERT INTO
              afspraken (
                voornaam,
                achternaam,
                datum,
                tijd,
                knipbeurt,
                kapper,
                email,
                telefoon
            ) VALUES (
              ?,
              ?,
              ?,
              ?,
              ?,
              ?,
              ?,
              ?
            )
        ";


    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('ssssssss', $voornaam, $achternaam, $date, $time, $cut, $barber, $email, $phone);

        if ($stmt->execute()) {
            $stmt->store_result();

            // if nothing happened we go to error page
            if ($stmt->affected_rows <= 0) {
                header("Location: error.php");
                die("Redirecting");
            }
        }

        $stmt->close();
    }

    mysqli_close($db);

    // if we reach this it was a success and we go to the 'thank you' page
    header("location: confirmation.php");
    die("Redirecting");
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<script src="scripts/select.js"></script>
</body>
</html>