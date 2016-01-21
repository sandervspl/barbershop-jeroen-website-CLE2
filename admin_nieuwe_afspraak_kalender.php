<?php
require("common.php");
require_once "nlDate.php";
require_once "User.php";

if(isset($_SESSION['user'])) {
    $user_ = new User;

    // level check
    $isAdmin = $user_->getUserLvl();
    if (!$isAdmin) {
        header("Location: forbidden.php");
        die("Redirecting to forbidden.php");
    }

    // in de URL kan je een maand en jaar zetten wat vervolgens in de kalender tevoorschijn komt
    // bijv: calendar_clean.php?month=1&year=2016 laat januari 2016 zien
    // als er niks in de URL staat dan pakken we de huidige maand & jaar
    if (isset($_GET['month']) && isset($_GET['year'])) {
        $month = $_GET['month'];
        $year  = $_GET['year'];
    } else {
        $month = date("n");
        $year  = date("Y");
    }

    // next month button variables
    $prevyear  = $year;
    $prevmonth = $month - 1;
    $nextyear  = $year;
    $nextmonth = $month + 1;

    if ($prevmonth < 1) {
        $prevmonth = 12;
        $prevyear--;
    }

    if ($nextmonth > 12) {
        $nextmonth = 1;
        $nextyear++;
    }

    $starting_day = "$year-$month-1";
    $time = strtotime($starting_day);
} else {
    header("Location: forbidden.php");
    die("Redirecting to forbidden.php");
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<?php
if (!isset($_GET['p'])) {
?>
<section id="main-page">
    <p id="header-text-header">Kalender</p>
    <div id="basic-wrapper">
        <div class="ta-left">
            <a href="admin.php">< admin pagina</a>
        </div>

        <div class="white-background">
            <div id="account-text">
                <p class="header-text">Kies Kapper</p>
            </div>

            <div class="divider-light"></div>
            <br />

            <section id="basic-wrapper" class="choose-barber">
                <a href="admin_nieuwe_afspraak_kalender.php?p=1">Jeroen</a> <br />
                <a href="admin_nieuwe_afspraak_kalender.php?p=2">Juno</a> <br />
            </section>
        </div>
    </div>
</section>
<?php
} else {
    if ($_GET['p'] == 1) {
        $barber = "Jeroen";
        $_SESSION['barber'] = "Jeroen";
        $p = 1;
    } else {
        $barber = "Juno";
        $_SESSION['barber'] = "Juno";
        $p = 2;
    }
?>

<section id="main-page">
    <p id="header-text-header" class="margin-b-100">Kalender</p>

    <form name="calendar-form" method="post">

    <div id="basic-wrapper">
        <div class="ta-left">
            <a href="admin_nieuwe_afspraak_kalender.php">< andere kapper</a>
        </div>

        <div class="admin-barber-name-wrapper ta-left">
            <p class="header-text admin-barber-name-appointments"><?= $barber ?></p>
        </div>

        <div class="white-background">
        <div class="admin-calendar-wrapper">
            <div class="month-name admin-month-name">
                <div id="admin-month-name-header-helper">
                    <span id="calendar-header-text" class="header-text admin-calendar-header-text"><?= nlDate(date("F Y", $time)) ?></span>
                </div>
                <div id="month-arrow-helper">
                    <a href="<?=$_SERVER['PHP_SELF']."?p=$p&month=$prevmonth&year=$prevyear"?>">
                        <img src="images/booking/calendar_left.png" id="calendar-arrow-left" onmouseover="nhpup.popup('Vorige maand')">
                    </a>
                    <a href="<?=$_SERVER['PHP_SELF']."?p=$p&month=$nextmonth&year=$nextyear"?>">
                        <img src="images/booking/calendar_right.png" id="calendar-arrow" class="admin-calendar-arrow" onmouseover="nhpup.popup('Volgende maand')">
                    </a>
                </div>
            </div>



            <table id="calendar" class="admin-calendar">
                <tr class="calendarday">
                    <th>Ma</th>
                    <th>Di</th>
                    <th>Wo</th>
                    <th>Do</th>
                    <th>Vr</th>
                    <th>Za</th>
                    <th>Zo</th>
                </tr>
                <tr>

                    <?php
                    // grab weekday (Mon - Sun) of current time
                    $weekday = date("D", $time);

                    // create array which we later go through in reverse to put in table
                    $prevmontharray = [];

                    // look for first monday in the past starting from current time
                    while ($weekday !== "Mon") {
                        $time = strtotime("-1 day", $time);
                        $prevmontharray[] = date("d", $time);
                        $weekday = date("D", $time);
                    }



                    // go through array in reverse to fill table
                    for ($i = (count($prevmontharray)-1); $i >= 0; $i--) { ?>
                        <td class="calendardateblocked">
                            <div class="divBox">
                                <span> <?= $prevmontharray[$i] ?> </span>
                            </div>
                        </td>
                        <?php
                    }



                    // reset time to first day of chosen month
                    $time    = strtotime($starting_day);
                    $day     = date("d", $time);
                    $weekday = date("D", $time);
                    $daysinmonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);




                    // **************************************
                    // loop through our current month
                    //
                    for ($i = 0; $i < $daysinmonth; $i++) {

                        // info for date click
                        // these need to be surrounded by '' otherwise they will not get correctly passed into the onclick JS function
                        $weekday_f = "'" . nldate(date("l", $time)) . "'";  // Monday-Sunday
                        $monthname = "'" . nldate(date("F", $time)) . "'";  // January-December

                        // check if this date is current date
                        $date    = date("Y-m-d", $time);
                        $curdate = date("Y-m-d");

                        if ($date === $curdate) {
                            $todayclass = "calendartoday";
                        } else {
                            $todayclass = "";
                        }

                        // every monday we need to start a new table row
                        if ($weekday === "Mon") { ?>
                    </tr>
                    <tr>
                        <?php
                        }
                        ?>
                        <td class="calendardate cut-selector <?=$todayclass?>">
                            <div class="divBox">
                                <input type="radio" id="<?= $date ?>" class="date-radio" name="date" value="<?= $date ?>" onclick="onDateClickAdminCalendar(<?=$day?>, <?=$weekday_f?>, <?=$monthname?>, <?=$month?>, <?=$year?>, <?=$_GET['p']?>)">
                                <label for="<?= $date ?>"> <?= $day ?> </label>
                            </div>
                        </td>
                        <?php

                        // go up one day
                        $time    = strtotime("+1 day", $time);
                        $day     = date("d", $time);
                        $weekday = date("D", $time);
                    }




                    // fill the calender with next month data if this month does not end on a sunday
                    while ($weekday !== "Mon") {
                        ?>
                        <td class="calendardateblocked <?=$todayclass?>">
                            <div class="divBox">
                                <span> <?= $day ?> </span>
                            </div>
                        </td>
                        <?php

                        $time    = strtotime("+1 day", $time);
                        $day     = date("d", $time);
                        $weekday = date("D", $time);
                    }
                    ?>
                </tr>
            </table>
            </div>
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
<?php
    }

    require_once "footer.php"
?>
</footer>

<script src="scripts/admin.js"></script>
<script src="scripts/calendar.js"></script>
</body>
</html>