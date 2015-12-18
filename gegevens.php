<?php
if(!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['cut']) || !isset($_SESSION['date']) || !isset($_SESSION['time'])) {
    header("Location: reserveer.php");
}

$voornaam = '';
$achternaam = '';
$phone = '';
$email = '';

if (isset($_POST['submit'])) {
    require_once "gegevens_check.php";
}
?>
<!DOCTYPE HTML>
<html lang="en">
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
    <p id="header-text-header">Bevestig Afspraak</p>
<div id="wrapper">
    <div id="summary-wrapper">
        <p class="header-text">Bestelling</p>
        <div id="summary-wrapper-text">
            <span class="barber-name"><?=$_SESSION['barber']?></span><br/>
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
                        <input type="text" id="voornaam" class="textinput" name="voornaam" autofocus="autofocus" value="<?=$voornaam?>" />
                    </p>
                    <p>
                        <label class="input-text" for="achternaam">Achternaam</label>
                        <input type="text" id="achternaam" class="textinput" name="achternaam" value="<?=$achternaam?>" />
                    </p>
                    <p>
                        <label class="input-text" for="email">E-Mail</label><br/>
                        <input type="email" id="email" class="textinput" name="email" value="<?=$email?>" />
                    </p>

                    <p>
                        <label class="input-text" for="phone">Telefoon</label><br/>
                        <input type="text" id="phone" class="textinput" name="phone" value="<?=$phone?>" />
                    </p>
                </div>

                <input type="submit" name="submit" class="button" value="reserveer" />
            </form>
        </div>
    </section>
</div>

</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>