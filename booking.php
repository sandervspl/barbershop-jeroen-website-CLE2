<?php
if(!isset($_SESSION)) {
    session_start();
}

require_once "nlDate.php";

if (!isset($_SESSION['cut'])) {
    header("Location: reserveer.php");
}

if (isset($_POST['timestablebutton']) && isset($_POST['date'])) {
    $values = explode("|", $_POST['timestablebutton']);
    $_SESSION['date'] = $_POST['date'];
    $_SESSION['time'] = $values[0];
    $_SESSION['barber'] = $values[1];

    header("location: gegevens.php");
}

// grab current year/month and start at day 01
$starting_day = date("Y-m-")."01";
$time = strtotime($starting_day);

$month = date("m", $time);
$year = date("Y", $time);

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $starting_day = $year ."-". $month ."-". "01";
    $time = strtotime($starting_day);
}

$monthname = nlDate(date("F", $time));
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classics Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'>
    <script>
        window.sessionStorage.currentDayTimes = 0;
    </script>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Dag & Tijd</p>
    <div id="summary-header">
        <div class="white-background">
            <table class="header-text">
                <tr>
                    <th>Wat</th>
                    <th>Tijdsduur</th>
                    <th>Wie</th>
                </tr>
                <tr>
                    <td><img id="cut" class="hair-beard-img" src="images/index/no-hair-no-beard.png"></td>
                    <td><img id="cut-time" class="hair-beard-img" src="images/booking/timer_clear.png"><p id="cut-time-text">0min</p></td>
                    <td><span class="barber-name"><?=$_SESSION['barber']?></span></td>
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
            <img id="calendar-arrow" src="images/booking/calendar_right.png" onclick="nextMonth(this, <?=$month?>, <?=$year?>, 0)">
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
                <div id="times-table"></div>
            </div>
        </section>
    </form>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>