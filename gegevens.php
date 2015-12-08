<?php
include_once "gegevens_check.php";
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
                        <label class="input-text" for="firstNameInput">Voornaam</label>
                        <input id="firstNameInput" name="FirstName" type="text" autofocus="autofocus" class="textinput"/>
                    </p>
                    <p>
                        <label class="input-text" for="lastNameInput">Achternaam</label>
                        <input id="lastNameInput" name="LastName" type="text" class="textinput" size="10"/>
                    </p>
                    <p>
                        <label class="input-text" for="emailInput">Email</label><br/>
                        <input id="emailInput" name="Email" type="email" class="textinput"/>
                    </p>

                    <p>
                        <label class="input-text" for="phoneInput">Telefoon</label><br/>
                        <input id="phoneInput" name="PhoneNumber" type="text" class="textinput"/>
                    </p>
                </div>

                <input type="submit" class="button" value="Reserveer"/>
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