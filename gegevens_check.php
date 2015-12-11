<?php
$voornaam = '';
$achternaam = '';
$email = '';
$phone = '';
$barber = '';
$date = '';
$time = '';
$cut = '';

$ok = true;
if (!isset($_POST['voornaam']) || $_POST['voornaam'] === '') {
    $ok = false;
    echo "Error: VOORNAAM variable is not set. ";
} else {
    $voornaam = $_POST['voornaam'];
}
if (!isset($_POST['achternaam']) || $_POST['achternaam'] === '') {
    $ok = false;
    echo "<br /> Error: ACHTERNAAM variable is not set. ";
} else {
    $achternaam = $_POST['achternaam'];
}
if (!isset($_POST['email']) || $_POST['email'] === '') {
    $ok = false;
    echo "<br /> Error: EMAIL variable is not set. ";
} else {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $ok = false;
        echo "Error: Invalid EMAIL.";
    } else {
        $email = $_POST['email'];
    }
}
if (!isset($_POST['phone']) || $_POST['phone'] === '') {
    $ok = false;
    echo "<br /> Error: PHONE variable is not set. ";
} else {
    if (preg_match("[0-9]{10}", $_POST['phone'])) {
        $ok = false;
        echo "Error: Invalid PHONE.";
    }
    $phone = $_POST['phone'];
}
if (!isset($_SESSION['barber']) || $_SESSION['barber'] === '') {
    $ok = false;
    echo "<br /> Error: BARBER variable is not set. ";
} else {
    $barber = $_SESSION['barber'];
}
if (!isset($_SESSION['date']) || $_SESSION['date'] === '') {
    $ok = false;
    echo "<br /> Error: DATE variable is not set. ";
} else {
    $date = $_SESSION['date'];
}
if (!isset($_SESSION['time']) || $_SESSION['time'] === '') {
    $ok = false;
    echo "<br /> Error: TIME variable is not set. ";
} else {
    $time = $_SESSION['time'];
}
if (!isset($_SESSION['cut']) || $_SESSION['cut'] === '') {
    $ok = false;
    echo "<br /> Error: CUT variable is not set. ";
} else {
    $cut = $_SESSION['cut'];
}

// check if appointment already exists
$db = mysqli_connect('localhost', 'root', '', 'website') or die('Error: '.mysqli_connect_error());
$sql = sprintf("SELECT * FROM afspraken WHERE datum='%s' AND tijd='%s' AND kapper='%s'",
    mysqli_real_escape_string($db, $_SESSION['date']),
    mysqli_real_escape_string($db, $_SESSION['time']),
    mysqli_real_escape_string($db, $_SESSION['barber']));
$result = mysqli_query($db, $sql);

if (mysqli_num_rows($result) > 0) {
    $ok = false;
    echo "<br /> Error: Appointment already exists.";
}

mysqli_close($db);

if ($ok) {
//        $date = date("Y-") . $month . "-" . $day;
    // add to db
    $db = mysqli_connect('localhost', 'root', '', 'website') or die('Error: '.mysqli_connect_error());

    $sql = sprintf("INSERT INTO afspraken (voornaam, achternaam, datum, tijd, knipbeurt, kapper, email, telefoon) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($db, $voornaam),
        mysqli_real_escape_string($db, $achternaam),
        mysqli_real_escape_string($db, $date),
        mysqli_real_escape_string($db, $time),
        mysqli_real_escape_string($db, $cut),
        mysqli_real_escape_string($db, $barber),
        mysqli_real_escape_string($db, $email),
        mysqli_real_escape_string($db, $phone)
    );
    mysqli_query($db, $sql);
    mysqli_close($db);

    // go to next page (thanks for your reservation etc.)
    header("location: confirmation.php");
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