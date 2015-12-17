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
</head>
<body>

<header>
    <div id="main-header">
        <a href="index.php"><img src="images/other/bblogo.png" id="header-logo"></a>
    </div>
    <nav id="navigation-background">
        <div class="navigation-helper">
            <ul>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php">Over Ons</a></li>
                <li><a href="reserveer.php">Reserveer</a></li>
                <li>
                    <?php if (isset($_SESSION['user']['username'])) { ?>
                        <a href="login/private.php" id="login-button">[<?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>]</a>
                    <?php } else { ?>
                        <a href="login/login.php" id="login-button">Login</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </nav>
</header>

<section id="main-page">
    <p id="header-text-header">Wie zijn wij</p>
    <div id="over-ons">
        <div class="white-background">
            <div id="over-ons-text">
                <p class="header-text">Classics Barbershop</p>
                <br />
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
                    <tr>
                        <td>Maandag</td>
                        <td>GESLOTEN</td>
                    </tr>
                    <tr>
                        <td>Dinsdag</td>
                        <td>09:00 - 18:00</td>
                    </tr>
                    <tr>
                        <td>Woensdag</td>
                        <td>09:00 - 18:00</td>
                    </tr>
                    <tr>
                        <td>Donderdag</td>
                        <td>11:00 - 20:00</td>
                    </tr>
                    <tr>
                        <td>Vrijdag</td>
                        <td>09:00 - 18:00</td>
                    </tr>
                    <tr>
                        <td>Zaterdag</td>
                        <td>09:00 - 17:00</td>
                    </tr>
                    <tr>
                        <td>Zondag</td>
                        <td>GESLOTEN</td>
                    </tr>
                </table>
                <br/>
                <div class="divider-light"></div>
                <br />
                <p class="header-text-small">Tot snel!</p>
            </div>
        </div>
        <div class="white-background white-background-margin">
            <div id="over-ons-barbers">
                <p class="header-text">De barbers</p>
                <div class="divider-light"></div>
                <br />
                <div id="over-ons-jeroen-wrapper">
                    <p class="header-text-lobster">Jeroen</p>
                    <img src="images/index/jeroen.jpg">
                </div>
                <div id="over-ons-juno-wrapper">
                    <p class="header-text-lobster">Juno</p>
                    <img src="images/index/juno.jpg">
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
</footer>
</body>
</html>