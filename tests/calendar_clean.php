<?php

if (isset($_POST['submit']) && isset($_POST['date'])) {
    echo "Gekozen dag: " . $_POST['date'];
}

// in de URL kan je een maand en jaar zetten wat vervolgens in de kalender tevoorschijn komt
// bijv: calendar_clean.php?month=1&year=2016 laat januari 2016 zien
// als er niks in de URL staat dan pakken we de huidige maand & jaar
if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year  = $_GET['year'];
} else {
    $month = date("m");
    $year  = date("Y");
}

$starting_day = "$year-$month-1";
$time = strtotime($starting_day);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Kalender</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!--gegeven maand boven de kalender-->
<h1><?= date("F", $time); ?></h1>

<form name="calendar-form" method="post">
<table id="calendar">
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
            $day       = date("d", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));    // 01-31
            $weekday   = date("D", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));    // Mon-Sun

            // huidige dag & maand
            $curday = date("d");
            $curmonth = date("m");

            // pak de naam van de gegeven maand
            $monthname = date("F", $time);                                                                        // January-December

            // vorm een datum. Dit wordt bijv. 2016-01-01
            $date      = $year . "-" . date("m-", $time) . $day;                                                   // YYYY-MM-DD



            // niet elke maand begint netjes op een maandag
            // 1 januari 2016 begint op een vrijdag, dus we moeten maandag t/m donderdag vullen met dagen van december 2015
            if ($day === "01" && $weekday !== "Mon" && !$endPrevMonth) {
                $i = 1;

                // loop en tel af tot we een dag vinden dat een maandag is
                do {
                    // zet dag data in variabelen. We tellen de dag af met $i per loop
                    $prevMonthDay        = date("d", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                    $prevMonthWeekDay    = date("D", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));

                    // zet deze data in een array, deze gebruiken we later om onze td's te vullen
                    $prevMonthDayArray[] = $prevMonthDay;

                    // tel $i op. Volgende loop moeten we naar 2 dagen geleden kijken. Daarna naar 3 dagen geleden etc.
                    $i++;

                    // Als we een maandag vinden of we loopen meer dan een 7 dagen dan kan deze do-while-loop stoppen.
                    if ($i > 7 || $prevMonthWeekDay === "Mon") {
                        $endPrevMonth = true;
                    }
                }while(!$endPrevMonth);

                // loop door de array heen en vul een td met de data
                // we telden net wel achteruit. Voor 1 januari was 31 december, en daarvoor 30 december, etc.
                $prevMonthDays = count($prevMonthDayArray) - 1;

                // de for loop begint dus bij ons voorbeeld bij $i = 4 (Do, Wo, Di, Ma moeten gevuld worden met december dagen)
                // we tellen af tot we bij nul zijn
                for ($i = $prevMonthDays; $i >= 0; $i--) { ?>
                    <td class="blocked">
                        <div>
                            <span> <?=$prevMonthDayArray[$i]?> </span>
                        </div>
                    </td> <?php
                }

                // vul de eerste dag van onze gegeven maand is
                // als de dag al geweest is dan blokkeren we hem
                // geef het een radio button zodat erop geklikt kan worden en je de gekozen dag kan invoeren met een form
                if ($day < $curday && $curmonth === $month) { ?>
                    <td class="blocked">
                        <div>
                            <span> <?=$day?> </span>
                        </div>
                    </td> <?php
                } else { ?>
                    <td class="open">
                        <div>
                            <input type="radio" id="<?=$date?>" class="date-radio" name="date" value="<?=$date?>" />
                            <label for="<?=$date?>"> <?=$day?> </label>
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
                            <td class="blocked">
                                <div>
                                    <span> <?=$day?> </span>
                                </div>
                            </td> <?php
                        } else { ?>
                            <td class="open">
                                <div>
                                    <input type="radio" id="<?=$date?>" class="date-radio" name="date" value="<?=$date?>" />
                                    <label for="<?=$date?>"> <?=$day?> </label>
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
                        <td class="blocked">
                            <div>
                                <span> <?=$day?> </span>
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
        }while(!$endMonth);
        ?>
    </tr>
</table>

    <div class="submit-button"><input type="submit" name="submit" value="submit"></div>
</form>
</body>
</html>