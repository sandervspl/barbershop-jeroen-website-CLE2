<?php
session_start();

include_once "nlDate.php";

echo $_SESSION['barber'];

if (!isset($_SESSION['cut'])) {
    header("Location: reserveer.php");
}

if (isset($_POST['time']) && isset($_POST['date'])) {
    $_SESSION['date'] = $_POST['date'];
    $_SESSION['time'] = $_POST['time'];
    $_SESSION['barber'] = $barber;

    header("location: gegevens.php");
} else {
    $barber = "Lul";
}

// grab current year/month and start at day 01
$starting_day = date("Y-m-")."01";
$time = strtotime($starting_day);

$monthname = nlDate(date("F", $time));
$month = date("m", $time);
$year = date("Y", $time);
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
                <li><a href="overons.php">Over Ons</a></li>
                <li><a href="reserveer.php">Reserveer</a></li>
            </ul>
        </div>
    </nav>
</header>

<section id="main-page">
    <p id="header-text-header">Dag & Tijd</p>
    <div id="summary-header">
    <div class="white-background">
        <table class="header-text">
            <tr>
                <th>Wat</th>
                <th>Tijdsuur</th>
                <th>Wie</th>
            </tr>
            <tr>
                <td><img id="cut" class="hair-beard-img" src="images/index/no-hair-no-beard.png"></td>
                <td><img id="cut-time" class="hair-beard-img" src="images/booking/timer_clear.png"></td>
                <td><span class="barber-name"></span></td>
                <script src="scripts/select.js"></script>
                <script type="text/javascript">
                    cutSelected();
                    barberSelected();
                </script>
            </tr>
        </table>
    </div>
    </div>

    <!--  month name above calendar  -->
    <div class="month-name">
        <div id="month-name-header-helper">
            <span id="calendar-header-text" class="header-text"><?= $monthname; ?></span>
        </div>
        <div id="month-arrow-helper">
            <img id="calendar-arrow" src="images/booking/calendar_right.png" onclick="nextMonth(this, <?=$month?>, <?=$year?>)">
            </div>
    </div>
    <form name="datetime" method="post">

    <!--  calendar  -->
        <div id="calendar-wrapper">
            <div class="white-background">
                <div id="calendar-table"><span class="header-text"></span></div>
                <script src="scripts/calendar.js"></script>
                <script type="text/javascript">
                    loadCalendar(<?=$month?>, <?=$year?>);
                </script>
            </div>
        </div>

    <!--  clicked date from calendar  -->
    <section id="date-and-time">
        <span id="date-and-time-header" class="header-text"></span>

        <!--  contains all times from that day  -->
        <div id="date-and-time-times-container">

            <!--  all times here come from timestable.php via AJAX code in calendar.js  -->
            <div id="times-table">
                <span class="header-text">
                    <form id="mobile-dropdown-lists">
                        <label for="hour">Uur</label>
                        <select name="hour" title="hour">
                            <option value="09">09</option>
                            <option value="10">10</option>
                        </select>

                        <label for="minute">Minuut</label>
                        <select name="minute" title="minute">
                            <option value="00">00</option>
                            <option value="30">30</option>
                        </select>
                    </form>
                </span>
            </div>
        </div>
    </section>
    </form>
</section>

<footer>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>