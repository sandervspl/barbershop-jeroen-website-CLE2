<?php
require("common.php");
require_once("admincheck.php");

if(isset($_SESSION['user'])) {

    // level check
    $isAdmin = isAdmin();
    if (!$isAdmin) {
        header("Location: forbidden.php");
        die("Redirecting to forbidden.php");
    }
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
    <p id="header-text-header">Admin Pagina</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <div id="account-wrapper-wide">
                <div id="account-text">
                    <p class="header-text">Opties</p>

                    <a href="admin_nieuwe_afspraak_kalender.php">Afspraken kalender</a><br />
                    <br />
                    <a href="logout.php">Uitloggen</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>