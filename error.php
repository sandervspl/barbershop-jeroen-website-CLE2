<?php
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

    <script>
        window.sessionStorage.cut = 0;
        window.sessionStorage.barber = 0;
        window.sessionStorage.time = 0;
        window.sessionStorage.end_time = 0;
        window.sessionStorage.cut_time = 0;
        window.sessionStorage.cut_month = 0;
        window.sessionStorage.cut_monthday = 0;
    </script>
</head>
<body>

<header>
    <div id="main-header">
        <a href="index.php"><img src="http://barbershopbarcelona.com/wp-content/uploads/2014/11/thebarbershop-Redondo.png" id="header-logo"></a>
        <span id="header-name">Classic Barbershop Jeroen</span>
    </div>
    <nav id="navigation-background">
        <div class="navigation-helper">
            <ul>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Over Ons</a></li>
                <li><a href="#">Reserveer</a></li>
            </ul>
        </div>
    </nav>
</header>

<section id="main-page">
    <p id="header-text-header">Oops!</p>
    <img id="img-big" src="images/other/error.png">
    <p class="header-text-lobster">Er is iets misgegaan.</p><br />
    <p class="header-text-small"><a href="index.php">Ga terug naar de hoofdpagina.</a></p>
</section>

<footer>
</footer>
</body>
</html>