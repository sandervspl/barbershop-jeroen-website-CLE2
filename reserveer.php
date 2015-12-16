<?php
if(!isset($_SESSION)) {
    session_start();
}

if (!isset($_POST['submit'])) {
    $_SESSION['barber'] = '';
    $_SESSION['cut'] = '';
    $_SESSION['date'] = '';
    $_SESSION['time'] = '';
} else {
    if (isset($_POST['cut'])) {
        if (isset($_POST['barber'])) {
            $_SESSION['barber'] = $_POST['barber'];
        } else {
            $_SESSION['barber'] = 'geenvoorkeur';
        }

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
        window.sessionStorage.time = 0;
        window.sessionStorage.end_time = 0;
        window.sessionStorage.cut_time = 0;
        window.sessionStorage.cut_month = 0;
        window.sessionStorage.cut_monthday = 0;
        window.sessionStorage.barber = 0;
        window.sessionStorage.currentDayTimes = 0;
    </script>
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
    <p id="header-text-header">Knipbeurt & Kapper</p>
    <div>
        <form id="mainForm" action="#" method="post">
            <div class="cut-selector">
            <div class="white-background">
                <p class="header-text">Knipbeurt</p>
                <div id="cuts">
                <input id="hair" type="radio" name="cut" value="haar" onclick="cutSelect(this)" />
                <label class="trans hair" for="hair" onclick="cutSelect(this)"></label>

                <input id="beard" type="radio" name="cut" value="baard" onclick="cutSelect(this)" />
                <label class="trans beard" for="beard"></label>

                <input id="moustache" type="radio" name="cut" value="snor" onclick="cutSelect(this)" />
                <label class="trans moustache" for="moustache"></label>

                <input id="all" type="radio" name="cut" value="alles" onclick="cutSelect(this)" />
                <label class="trans all" for="all"></label>
                </div>
            </div>
                <div class="divider"></div>

            <div class="white-background">
                <p class="header-text">Kapper</p>
                <div id="barbers">
                    <input id="Jeroen" type="radio" name="barber" value="Jeroen" onclick="barberSelection(this)" />
                    <label class="trans barber-selection" for="Jeroen">Jeroen</label>

                    <input id="Juno" type="radio" name="barber" value="Juno" onclick="barberSelection(this)" />
                    <label class="trans barber-selection" for="Juno">Juno</label>

                    <p>Laat leeg als je geen voorkeur hebt.</p>
                </div>
            </div>
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