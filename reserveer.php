<!--TODO: veranderd tijdsduur iconen (niet duidelijk, vooral niet bij 1 uur lang)-->

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
    <title>Classics Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:700' rel='stylesheet' type='text/css'>
    <script src="scripts/jquery-1.11.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        window.sessionStorage.cut = 0;
        window.sessionStorage.time = 0;
        window.sessionStorage.end_time = 0;
        window.sessionStorage.cut_time = 0;
        window.sessionStorage.cut_month = 0;
        window.sessionStorage.cut_monthday = 0;
        window.sessionStorage.barber = 0;
    </script>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Reserveren</p>
    <div>
        <form id="mainForm" action="#" method="post">
            <div class="cut-selector">
                <div class="white-background">
                    <div id="cuts">
                    <p class="header-text">Knipbeurt</p>
                    <input id="hair" type="radio" name="cut" value="haar" onclick="cutSelect(this)" />
                    <label class="trans hair" for="hair" onmouseover="nhpup.popup('Alleen haar')"></label>

                    <input id="beard" type="radio" name="cut" value="baard" onclick="cutSelect(this)" />
                    <label class="trans beard" for="beard" onmouseover="nhpup.popup('Alleen baard')"></label>

                    <input id="moustache" type="radio" name="cut" value="snor" onclick="cutSelect(this)" />
                    <label class="trans moustache" for="moustache" onmouseover="nhpup.popup('Alleen snor')"></label>

                    <input id="all" type="radio" name="cut" value="alles" onclick="cutSelect(this)" />
                    <label class="trans all" for="all" onmouseover="nhpup.popup('Haar & baard')"></label>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="white-background">
                    <div id="barbers">
                        <p class="header-text">Kapper</p>
                        <input id="Jeroen" type="radio" name="barber" value="Jeroen" onclick="barberSelection(this)" />
                        <label class="trans barber-selection" for="Jeroen">Jeroen</label>

                        <input id="Juno" type="radio" name="barber" value="Juno" onclick="barberSelection(this)" />
                        <label class="trans barber-selection" for="Juno">Juno</label>

                        <p class="small-text">Laat leeg als je geen voorkeur hebt.</p>
                    </div>
                </div>
            </div>
            <button id="bookButton" type="submit" name="submit" class="button" onclick="checkBookButton()">Volgende</button>
        </form>
    </div>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>

<script src="scripts/popup.js"></script>
<script src="scripts/select.js"></script>
<script>lockButton("bookButton")</script>
</body>
</html>