<?php
if (isset($_POST['submit'])) {
    $voornaam = '';
    $achternaam = '';
    $email = '';            // TODO: Regex
    $phone = '';            // TODO: regex

    $ok = true;
    if (!isset($_POST['voornaam']) || $_POST ['voornaam'] === '') {
        $ok = false;
    } else {
        $voornaam = $_POST['voornaam'];
    }
    if (!isset($_POST['achternaam']) || $_POST ['achternaam'] === '') {
        $ok = false;
    } else {
        $achternaam = $_POST['achternaam'];
    }
    if (!isset($_POST['email']) || $_POST ['email'] === '') {
        $ok = false;
    } else {
        $email = $_POST['email'];
    }
    if (!isset($_POST['phone']) || $_POST ['phone'] === '') {
        $ok = false;
    } else {
        $phone = $_POST['phone'];
    }

    if ($ok) {
        $barber = "Jeroen";
        $date = "1-1-2015";
        $time = "16:00";

//        $date = date("Y-") . $month . "-" . $day;
        // add to db
        $db = mysqli_connect('localhost', 'root', '', 'website') or die('Error: '.mysqli_connect_error());

        $sql = sprintf("INSERT INTO afspraken (voornaam, achternaam, datum, tijd, baard, kapper) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
            mysqli_real_escape_string($db, $voornaam),
            mysqli_real_escape_string($db, $achternaam),
            mysqli_real_escape_string($db, $date),
            mysqli_real_escape_string($db, $time),
            mysqli_real_escape_string($db, "JA"),
            mysqli_real_escape_string($db, $barber)
        );
        mysqli_query($db, $sql);
        mysqli_close($db);

        // go to next page (thanks for your reservation etc.)
    } else {
        echo "FAILED";
    }
//    include_once "gegevens_check.php";
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
                        <label class="input-text" for="firstNameInput">Voornaam</label>
                        <input id="firstNameInput" name="voornaam" type="text" autofocus="autofocus" class="textinput"/>
                    </p>
                    <p>
                        <label class="input-text" for="lastNameInput">Achternaam</label>
                        <input id="lastNameInput" name="achternaam" type="text" class="textinput" size="10"/>
                    </p>
                    <p>
                        <label class="input-text" for="emailInput">Email</label><br/>
                        <input id="emailInput" name="email" type="email" class="textinput"/>
                    </p>

                    <p>
                        <label class="input-text" for="phoneInput">Telefoon</label><br/>
                        <input id="phoneInput" name="phone" type="text" class="textinput"/>
                    </p>
                </div>

                <input type="submit" name="submit" class="button" value="submit"/>
            </form>
        </div>
    </section>
</div>

<!--    <div class="spacer"></div>-->
</section>

<footer>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>