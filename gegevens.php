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
//        window.sessionStorage.cut = 0;
//        window.sessionStorage.barber = 0;
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
    <div id="summary-header">
        <table class="header-text">
            <tr>
                <th>Wat</th>
                <th>Tijd</th>
                <th>Wie</th>
            </tr>
            <tr>
                <td><img id="cut" class="hair-beard-img" src="images/index/no-hair-no-beard.png"></td>
                <td><img id="cut-time" class="hair-beard-img" src="images/booking/timer_clear.png"></td>
                <td><span class="barber-name">aaa</span></td>
                <script src="scripts/calendar.js"></script>
                <script type="text/javascript">
                    cutSelected();
                    barberSelected();
                </script>
            </tr>
        </table>
    </div>
</section>

<footer>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>