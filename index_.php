<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <title>Classic Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>

    <script>
        window.sessionStorage.cut = 0;
        window.sessionStorage.barber = 0;
    </script>
</head>
<body>

<header>
<div id="main-header">
    <a href="index_.php"><img src="http://barbershopbarcelona.com/wp-content/uploads/2014/11/thebarbershop-Redondo.png" id="header-logo"></a>
    <span id="header-name">Classic Barbershop Jeroen</span>
</div>
<nav id="navigation-background">
    <div class="navigation-helper">
        <ul>
            <li><a href="#">Contact</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Reserveer</a></li>
        </ul>
    </div>
</nav>
</header>

<section id="main-page">
    <p class="header-text">Ik wil...</p>
    <ul>
        <li><img src="images/index/yes-hair-no-beard.png" id="hair" class="hair-beard-img" onclick="cutSelect(this, this.src)" onmouseover="hover(this, this.src)" onmouseout="unhover(this, this.src)"></li>
        <li><img src="images/index/no-hair-yes-beard.png" id="beard" class="hair-beard-img" onclick="cutSelect(this, this.src)" onmouseover="hover(this, this.src)" onmouseout="unhover(this, this.src)"></li>
        <li><img src="images/index/no-hair-no-beard-yes-moustache.png" id="moustache" class="hair-beard-img" onclick="cutSelect(this, this.src)" onmouseover="hover(this, this.src)" onmouseout="unhover(this, this.src)"></li>
        <li><img src="images/index/yes-hair-yes-beard.png" id="all" class="hair-beard-img" onclick="cutSelect(this, this.src)" onmouseover="hover(this, this.src)" onmouseout="unhover(this, this.src)"></li>
    </ul>

    <p class="header-text">Door...</p>
    <ul>
        <li><label id="Jeroen" onclick="barberSelection(this)">Jeroen</label></li>
        <li><label id="Juno" onclick="barberSelection(this)">Juno</label></li>
    </ul>

    <div class="button">
        <span id="bookButton" onclick="checkBookButton()">Reserveer</span>
    </div>
</section>

<script src="scripts/select.js"></script>
</body>
</html>