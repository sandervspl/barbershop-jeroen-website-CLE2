<?php
session_start();

if (isset($_POST['submit'])) {
    include_once "gegevens_check.php";
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classic Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
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
                <li><a href="#">About</a></li>
                <li><a href="#">Reserveer</a></li>
            </ul>
        </div>
    </nav>
</header>

<section id="main-page">
    <p id="header-text-header">Confirm appointment</p>
<div id="wrapper">
    <div id="summary-wrapper">
        <p class="header-text">Bestelling</p>
        <div id="summary-wrapper-text">
            <span class="barber-name">Jeroen</span><br/>
                <p id="chosen-month">32 January</p>
            <div id="summary-wrapper-text-time">
                <span id="chosen-time">03:22</span>
                <span id="chosen-etime">04:20</span>
            </div>
        </div>
        <div id="summary-wrapper-icon">
            <img id="cut" class="hair-beard-img" src="images/index/no-hair-no-beard.png">
        </div>
        <script src="scripts/select.js"></script>
        <script type="text/javascript">
            cutSelected();
            barberSelected();
            timeSelected();
            monthSelected();
        </script>
    </div>

    <section id="gegevens-form">
        <div>
            <form id="mainForm" action="#" method="post">
                <div>
                    <p>
                        <label class="input-text" for="voornaam">Voornaam</label>
                        <input id="voornaam" name="voornaam" type="text" autofocus="autofocus" class="textinput" />
                    </p>
                    <p>
                        <label class="input-text" for="achternaam">Achternaam</label>
                        <input id="achternaam" name="achternaam" type="text" class="textinput" />
                    </p>
                    <p>
                        <label class="input-text" for="email">Email</label><br/>
                        <input id="email" name="email" type="email" class="textinput" />
                    </p>

                    <p>
                        <label class="input-text" for="phone">Telefoon</label><br/>
                        <input id="phone" name="phone" type="text" class="textinput" />
                    </p>
                </div>

                <input type="submit" name="submit" class="button" value="reserveer" />
            </form>
        </div>
    </section>
</div>

</section>

<footer>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>