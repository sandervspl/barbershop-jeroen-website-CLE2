<?php
require("common.php");
require_once "nlDate.php";
require_once "admincheck.php";

if(isset($_SESSION['user'])) {

    // level check
    $isAdmin = isAdmin();
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
<!--        <div class="ta-left">-->
<!--            <a href="admin.php">< admin pagina</a>-->
<!--        </div>-->

<!--        <div class="white-background">-->
<!--            <div id="account-text" class="ta-center">-->
<!--                <p class="header-text admin-barber-name-calendar">--><?//= $barber ?><!--</p><br />-->
<!--                <a href="admin_nieuwe_afspraak_kalender.php" class="admin-select-barber">Andere kapper</a>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <br />-->


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

                    $endMonth = false;
                    $endPrevMonth = false;
                    $doNextMonth = false;
                    $prevDay = -1;
                    $counter = 0;

                    // start building up the calendar table row, filling them with the days of the month
                    /*
                     * HOW IT WORKS:
                     * First we check if the first day of the month starts on a Monday
                     * If this is not the case, we count backwards until we do find Monday
                     * This way the calendar always has the correct day filled in the correct column
                     * 01(-12-2015) is a Tuesday for example, so we have to fill in the monday with 30(-11-2015)
                     * When Monday is found, we fill these previous month days into their cells (td)
                     * When that is done the current month can get filled in
                     * Every Monday we make a new table row (tr)
                     * When we go one day further and it becomes day 01 and one of the previous days was 28,29,30 or 31 we know
                     * we are at the end of our current month.
                     * To complete the calendar and not have gaps, we fill these in with the next month's dates until we are on Monday.
                     */
                    do {

                    // geef dag weer die we nodig hebben. We beginnen bij dag 1 van de gegeven maand & jaar en tellen met $counter op elke loop
                    $day =       date("d", mktime(0, 0, 0, date("m", $time), date("d", $time) + $counter, date("y", $time))); // 01-31
                    $weekday =   date("D", mktime(0, 0, 0, date("m", $time), date("d", $time) + $counter, date("y", $time))); // Mon-Sun
                    $weekday_f = date("l", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));        // Monday-Sunday
                    $monthname = date("F", $time);                                                                            // January-December

                    $weekday_f = "'" . $weekday_f . "'";
                    $monthname = "'" . $monthname . "'";

                    // translate to Dutch
                    $weekday_f = nlDate($weekday_f);
                    $monthname = nlDate($monthname);

                    // vorm een datum. Dit wordt bijv. 2016-01-01
                    $date = $year . "-" . date("m-", $time) . $day;                                                   // YYYY-MM-DD

                    // huidige dag & maand
                    $curday = date("d");
                    $curmonth = date("n");
                    $curdate = date("Y-m-d");

                    if ($date === $curdate) {
                        $todayclass = "calendartoday";
                    } else {
                        $todayclass = "";
                    }

                    // niet elke maand begint netjes op een maandag
                    // 1 januari 2016 begint op een vrijdag, dus we moeten maandag t/m donderdag vullen met dagen van december 2015
                    if ($day === "01" && $weekday !== "Mon" && !$endPrevMonth) {
                        $i = 1;

                        // loop en tel af tot we een dag vinden dat een maandag is
                        do {
                            // zet dag data in variabelen. We tellen de dag af met $i per loop
                            $prevMonthDay = date("d", mktime(0, 0, 0, date("m", $time), date("d", $time) - $i, date("y", $time)));
                            $prevMonthWeekDay = date("D", mktime(0, 0, 0, date("m", $time), date("d", $time) - $i, date("y", $time)));

                            // zet deze data in een array, deze gebruiken we later om onze td's te vullen
                            $prevMonthDayArray[] = $prevMonthDay;

                            // tel $i op. Volgende loop moeten we naar 2 dagen geleden kijken. Daarna naar 3 dagen geleden etc.
                            $i++;

                            // Als we een maandag vinden of we loopen meer dan een 7 dagen dan kan deze do-while-loop stoppen.
                            if ($i > 7 || $prevMonthWeekDay === "Mon") {
                                $endPrevMonth = true;
                            }
                        } while (!$endPrevMonth);

                        // loop door de array heen en vul een td met de data
                        // we telden net wel achteruit. Voor 1 januari was 31 december, en daarvoor 30 december, etc.
                        $prevMonthDays = count($prevMonthDayArray) - 1;

                        // de for loop begint dus bij ons voorbeeld bij $i = 4 (Do, Wo, Di, Ma moeten gevuld worden met december dagen)
                        // we tellen af tot we bij nul zijn
                        for ($i = $prevMonthDays; $i >= 0; $i--) { ?>
                            <td class="calendardateblocked <?=$todayclass?>">
                                <div class="divBox">
                                    <span> <?= $prevMonthDayArray[$i] ?> </span>
                                </div>
                            </td> <?php
                        }

                        // vul de eerste dag van onze gegeven maand is
                        // als de dag al geweest is dan blokkeren we hem
                        // geef het een radio button zodat erop geklikt kan worden en je de gekozen dag kan invoeren met een form
                        if ($day < $curday && $curmonth === $month) { ?>
                            <td class="calendardateblocked <?=$todayclass?>">
                                <div class="divBox">
                                    <span> <?= $day ?> </span>
                                </div>
                            </td> <?php
                        } else { ?>
                            <td class="calendardate cut-selector <?=$todayclass?>">
                                <div class="divBox">
                                    <input type="radio" id="<?= $date ?>" class="date-radio" name="date" value="<?= $date ?>" onclick="onDateClickAdminCalendar(<?=$day?>, <?=$weekday_f?>, <?=$monthname?>, <?=$month?>, <?=$year?>, <?=$_GET['p']?>)">
                                    <label for="<?= $date ?>"> <?= $day ?> </label>
                                </div>
                            </td> <?php
                        }


                        // nu gaan we verder met de rest van de gegeven maand (02 tot 28 / 31)
                    } else {

                    // als we bij een maandag zijn beginnen we een nieuwe tr
                    if ($endPrevMonth && $weekday === "Mon") { ?>
                </tr>
                <tr> <?php
                    }

                    // als de maand ook werkelijk begint op maandag dan moeten we ff zeggen dat we geen informatie van de vorige maand
                    // hebben ingevoerd. We zijn dus zogenaamd "klaar" met het invoeren van data van vorige maand
                    if (!$endPrevMonth) {
                        $endPrevMonth = true;
                    }

                    // als de dag van de huidige loop 01 is en de vorige 28,29,30 of 31 was dan zit de loop te tellen in de volgende maand
                    // als deze dag geen maandag is dan is het tijd om data van de volgende maand in onze kalender te stoppen
                    if ($day === "01" && ($prevDay === "31" || $prevDay === "30" || $prevDay === "29" || $prevDay === "28")) {
                        if ($weekday !== "Mon") {
                            $doNextMonth = true;
                        } else {
                            $endMonth = true;
                        }

                        // als dat allemaal niet het geval is, zitten we nog in de gegeven maand en vullen we data hiervan in
                    } else {
                        if (!$doNextMonth) {
                            if ($day < $curday && $curmonth === $month) { ?>
                                <td class="calendardateblocked <?=$todayclass?>">
                                    <div class="divBox">
                                        <span> <?= $day ?> </span>
                                    </div>
                                </td> <?php
                            } else { ?>
                                <td class="calendardate cut-selector <?=$todayclass?>">
                                    <div class="divBox">
                                        <input type="radio" id="<?= $date ?>" class="date-radio" name="date" value="<?= $date ?>" onclick="onDateClickAdminCalendar(<?=$day?>, <?=$weekday_f?>, <?=$monthname?>, <?=$month?>, <?=$year?>, <?=$_GET['p']?>)">
                                        <label for="<?= $date ?>"> <?= $day ?> </label>
                                    </div>
                                </td> <?php
                            }
                        }
                    }

                    // als we in de volgende maand zitten te tellen dan moeten we data invoeren tot we bij de eerstvolgende maandag zijn
                    if ($doNextMonth) {
                        if ($weekday === "Mon") {
                            $doNextMonth = false;
                            $endMonth = true;
                        } else { ?>
                            <td class="calendardateblocked <?=$todayclass?>">
                                <div class="divBox">
                                    <span> <?= $day ?> </span>
                                </div>
                            </td> <?php
                        }
                    }
                    }

                    // optellen van de dag als we de gegeven maand aan het invullen zijn
                    if ($endPrevMonth) {
                        $prevDay = $day;
                        $counter++;

                        // loop escaper
                        if ($counter > 100) {
                            $endMonth = true;
                        }
                    }
                    }while (!$endMonth);
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

<script src="scripts/popup.js"></script>
<script src="scripts/calendar.js"></script>
</body>
</html>