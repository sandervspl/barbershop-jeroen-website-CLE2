<?php
require("common.php");

if(isset($_SESSION['user'])) {
    $db =  mysqli_connect($host, $user, $pw, $database) or die('Error: '.mysqli_connect_error());

    $sql = sprintf("SELECT level FROM users WHERE username='%s'",
        $_SESSION['user']['username']);

    $result = mysqli_query($db, $sql);
    $re = mysqli_fetch_row($result);

    // if user level is not 1 (admin) then redirect
    if ($re[0] != 1) {
        header("Location: forbidden.php");
        die("Redirecting to forbidden.php");
    }

    mysqli_close($db);
} else {
    header("Location: forbidden.php");
    die("Redirecting to forbidden.php");
}
?>
<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classics Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:700' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Kalender</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <div id="account-wrapper-wide">
                VOEG KALENDER TOE <br />
                KLIK GAAT NAAR ADMIN_NIEUWE_AFSPRAAK
            </div>
        </div>
    </div>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>