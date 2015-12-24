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
    <p id="header-text-header">Wie Zijn Wij</p>
    <div id="over-ons">
        <div class="white-background">
            <div id="over-ons-text">
                <p class="header-text">Classics Barbershop</p>
                <p>Classics Barbershop Jeroen is een heren kapsalon op <a href="contact.php">Winkelcentrum De Passage in Zwijndrecht</a>.</p>
                <p>Wij zijn gespecialiseerd in het knippen van heren, maar ook uw kleine boefjes zijn welkom.</p>
                <p>U bent van harte welkom bij ons in de nieuwe zaak.</p>
                <br/>
                <div class="divider-light"></div>
                <br />
                <p>Om een afspraak te maken kunt u dat via ons gloednieuwe <a href="reserveer.php">online reserveersysteem</a> doen.</p>
                <p>Ouderwets <a href="contact.php">bellen of langskomen</a> is natuurlijk ook mogelijk.</p>
                <br />
                <table id="opening-times">
                    <tr><td>Maandag</td>
                        <td>GESLOTEN</td></tr>
                    <tr><td>Dinsdag</td>
                        <td>09:00 - 18:00</td></tr>
                    <tr><td>Woensdag</td>
                        <td>09:00 - 18:00</td></tr>
                    <tr><td>Donderdag</td>
                        <td>11:00 - 20:00</td></tr>
                    <tr><td>Vrijdag</td>
                        <td>09:00 - 18:00</td></tr>
                    <tr><td>Zaterdag</td>
                        <td>09:00 - 17:00</td></tr>
                    <tr><td>Zondag</td>
                        <td>GESLOTEN</td></tr>
                </table>
                <br/>
                <div class="divider-light"></div>
                <br />
                <p class="header-text-small">Tot snel!</p>
            </div>
        </div>
        <div class="white-background white-background-margin">
            <div id="over-ons-barbers">
                <p class="header-text">De Barbers</p>
                <p>Bij Classics Barbershop Jeroen is kwaliteit onze prioriteit.</p>
                <p>Jeroen, samen met Juno, zorgen er altijd voor dat u krijgt waar u voor betaald.</p>
                <br />
                <div class="divider-light"></div>
                <br />
                <div id="over-ons-jeroen-wrapper">
                    <img src="images/index/jeroen.jpg">
                    <p class="header-text-lobster">Jeroen</p>
                </div>
                <div id="over-ons-juno-wrapper">
                    <img src="images/index/juno.jpg">
                    <p class="header-text-lobster">Juno</p>
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