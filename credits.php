<?php
if(!isset($_SESSION)) {
    session_start();
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
    <p id="header-text-header">Site Credits</p>
    <div id="credits">
        <div class="white-background">
            <div id="credits-text">
                <h1>Artwork—</h1>
                <p>Mario Maldonado</p>
                <p>Lucas Almeida</p>
                <p>Guiditta Valentina Gentile</p>
                <p>Yaroslav Samoilov</p>
                <p>Bohdan Burmich</p>
                <p>Sagar Unagar</p>
                <p>Designify.me</p>
                <p><a href="https://thenounproject.com/">The Noun Project</a></p>
                <br />
                <h1>Coding—</h1>
                <p><a href="#">Sander Vispoel</a></p>
            </div>
        </div>
    </div>
</section>
<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>