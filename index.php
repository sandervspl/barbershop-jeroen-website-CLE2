<?php
session_start();

if (!isset($_POST['submit'])) {
    $_SESSION['barber'] = '';
    $_SESSION['cut'] = '';               // TODO: replace this with 'baard' in db
    $_SESSION['date'] = '';
    $_SESSION['time'] = '';
} else {
    if (isset($_POST['cut']) && isset($_POST['barber'])) {
        $_SESSION['barber'] = $_POST['barber'];
        $_SESSION['cut'] = $_POST['cut'];

        $url = "booking.php";
        header("location: $url");
    }
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
    <p id="header-text-header">Knipbeurt & Kapper</p>
    <div>
        <form id="mainForm" action="#" method="post">
            <p class="header-text">Knipbeurt</p>
            <div class="cut-selector">
                <input id="hair" type="radio" name="cut" value="haar" onclick="cutSelect(this)" />
                <label class="trans hair" for="hair" onclick="cutSelect(this)"></label>

                <input id="beard" type="radio" name="cut" value="baard" onclick="cutSelect(this)" />
                <label class="trans beard" for="beard"></label>

                <input id="moustache" type="radio" name="cut" value="snor" onclick="cutSelect(this)" />
                <label class="trans moustache" for="moustache"></label>

                <input id="all" type="radio" name="cut" value="alles" onclick="cutSelect(this)" />
                <label class="trans all" for="all"></label>

                <div class="divider"></div>

                <p class="header-text">Kapper</p>
                <input id="Jeroen" type="radio" name="barber" value="Jeroen" onclick="barberSelection(this)" />
                <label class="trans barber-selection" for="Jeroen">Jeroen</label>

                <input id="Juno" type="radio" name="barber" value="Juno" onclick="barberSelection(this)" />
                <label class="trans barber-selection" for="Juno">Juno</label>
            </div>
            <button id="bookButton" type="submit" name="submit" class="button" onclick="checkBookButton()">reserveer</button>
        </form>
    </div>
</section>

<footer>
</footer>

<script src="scripts/select.js"></script>
<script>lockButton("bookButton")</script>
</body>
</html>