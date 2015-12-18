<?php
if(!isset($_SESSION)) {
    session_start();
}

require_once "session_variables_check.php";

if (!$ok) {
    header ("Location: error.php");
}
?>
<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classic Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Reservering Compleet</p>
    <img id="img-big" src="images/confirmation/chair.png">
    <p class="header-text-big">Bedankt voor het reserveren!</p>
    <br />
    <p>Tot dan!</p>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>

<script src="scripts/select.js"></script>
</body>
</html>