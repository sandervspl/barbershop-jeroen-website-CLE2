<?php
$voornaam = '';
$achternaam = '';
$email = '';            // TODO: Regex
$phone = '';            // TODO: regex
$barber = '';
$date = '';
$time = '';

$ok = true;
if (!isset($_POST['voornaam']) || $_POST['voornaam'] === '') {
    $ok = false;
    echo "1-";
} else {
    $voornaam = $_POST['voornaam'];
}
if (!isset($_POST['achternaam']) || $_POST['achternaam'] === '') {
    $ok = false;
    echo "2-";
} else {
    $achternaam = $_POST['achternaam'];
}
if (!isset($_POST['email']) || $_POST['email'] === '') {
    $ok = false;
    echo "3-";
} else {
    $email = $_POST['email'];
}
if (!isset($_POST['phone']) || $_POST['phone'] === '') {
    $ok = false;
    echo "4-";
} else {
    $phone = $_POST['phone'];
}
if (!isset($_SESSION['barber']) || $_SESSION['barber'] === '') {
    $ok = false;
    echo "5-";
} else {
    $barber = $_SESSION['barber'];
}
if (!isset($_SESSION['date']) || $_SESSION['date'] === '') {
    $ok = false;
    echo "6-";
} else {
    $date = $_SESSION['date'];
}
if (!isset($_SESSION['time']) || $_SESSION['time'] === '') {
    $ok = false;
    echo "7";
} else {
    $time = $_SESSION['time'];
}

if ($ok) {
//        $date = date("Y-") . $month . "-" . $day;
    // add to db
    $db = mysqli_connect('localhost', 'root', '', 'website') or die('Error: '.mysqli_connect_error());

    $sql = sprintf("INSERT INTO afspraken (voornaam, achternaam, datum, tijd, baard, kapper, email, telefoon) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($db, $voornaam),
        mysqli_real_escape_string($db, $achternaam),
        mysqli_real_escape_string($db, $date),
        mysqli_real_escape_string($db, $time),
        mysqli_real_escape_string($db, "JA"),
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