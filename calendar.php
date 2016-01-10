<?php
if(!isset($_SESSION)) {
    session_start();
}

require_once "nlDate.php";
require_once "admincheck.php";

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $calendar_year = $_GET['year'];
    $starting_day = "$calendar_year-$month-1";
    $time = strtotime($starting_day);
} else {
    $month = date("n", $time);
    $calendar_year =  date("Y", $time);
}
?>
<!DOCTYPE HTML>
<html lang="en">
<body>
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
        function isFeestdag($day, $month) {
            $date = $day . "-" . $month;

            switch ($date) {
                case "01-1":           // nieuwjaarsdagen
                case "02-1":
                    $b = true;
                    break;

                case "03-4":           // goede vrijdag
                    $b = true;
                    break;

                case "27-4":           // koningsdag
                    $b = true;
                    break;

                case "5-5":           // bevrijdingsdag
                    $b = true;
                    break;

                case "25-12":           // eerste en tweede kerstdag
                case "26-12";
                    $b = true;
                    break;

                default:
                    $b = false;
            }

            return $b;
        }

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
            $day =       date("d", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));  // 01-31
            $weekday =   date("D", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));  // Mon-Sun
            $weekday_f = date("l", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));  // Monday-Sunday
            $monthname = date("F", $time);                                                                      // January-December

            $date = $calendar_year . "-" . date("n-", $time) . $day;                                            // YYYY-MM-DD

            $weekday_f = "'" . $weekday_f . "'";
            $monthname = "'" . $monthname . "'";

            // translate to Dutch
            $weekday_f = nlDate($weekday_f);
            $monthname = nlDate($monthname);

            $curday = date("d");
            $curmonth = date("n");
            $curdate = date("Y-n-d");

            if ($date === $curdate) {
                $todayclass = "calendartoday";
            } else {
                $todayclass = "";
            }

            // check if logged in user already has a appointment on this day
            $hasAppointmentOnDate = false;

            if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
                require_once "connect.php";

                $db = mysqli_connect($host, $user, $pw, $database) or die('Error: ' . mysqli_connect_error());

                $sql = "SELECT
                          1
                        FROM
                          afspraken
                        WHERE
                          email = ?
                        AND
                          datum >= ?
                        AND
                          datum = ?
                        LIMIT
                          1
                       ";

                if ($stmt = $db->prepare($sql)) {
                    $stmt->bind_param('sss', $_SESSION['user']['email'], $curdate, $date);

                    if ($stmt->execute()) {
                        $stmt->store_result();

                        if ($stmt->num_rows > 0 && !isAdmin()) {
                            $hasAppointmentOnDate = true;
                        }
                    }

                    $stmt->close();
                }
                mysqli_close($db);
            }

            if ($hasAppointmentOnDate) {
                $filledclass = "calendar-user-has-appointment";
                $filledhover = "nhpup.popup('Je hebt hier al een afspraak')";
            } else {
                $filledclass = "";
                $filledhover = "";
            }

            // previous month days
            if ($day === "01" && $weekday !== "Mon" && !$endPrevMonth) {
                $i = 1;

                // count backwards until we have a day that is a monday
                do {
                    $prevMonthDay =     date("d", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                    $prevMonthWeekDay = date("D", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                    $prevMonthDayArray[] = $prevMonthDay;

                    $i++;
                    if ($i > 7 || $prevMonthWeekDay === "Mon") {
                        $endPrevMonth = true;
                    }
                }while(!$endPrevMonth);

                // loop through the array backwards (we counted backwards: 01... 31... 30 for example)
                // put these in a special table cell
                $prevMonthDays = count($prevMonthDayArray) - 1;
                for ($i = $prevMonthDays; $i >= 0; $i--) { ?>
                    <td class="calendardateblocked <?=$todayclass?>">
                        <div class="divBox">
                            <span> <?=$prevMonthDayArray[$i]?> </span>
                        </div>
                    </td> <?php
                }

                // it will always miss day 1 on first row if this is not here. TODO: fix this
                if (($day < $curday && $curmonth === $month) ||
                     isFeestdag($day, $month) ||
                     $weekday === "Mon" || $weekday === "Sun" ||
                     ($_SESSION['barber'] === "Juno" && ($weekday === "Mon" || $weekday === "Wed" || $weekday === "Fri") ||
                     $hasAppointmentOnDate)
                ) { ?>
                    <td class="calendardateblocked <?=$todayclass?> <?=$filledclass?>" onmouseover="<?=$filledhover?>">
                        <div class="divBox">
                            <span> <?=$day?> </span>
                        </div>
                    </td> <?php
                } else { ?>
                    <td class="calendardate cut-selector <?=$todayclass?>">
                        <div class="divBox">
                            <input type="radio" id="<?=$date?>" class="date-radio" name="date" value="<?=$date?>" onclick="onDateClick(<?=$day?>, <?=$weekday_f?>, <?=$monthname?>, <?=$month?>, <?=$calendar_year?>, 0)" />
                            <label for="<?=$date?>"> <?=$day?> </label>
                        </div>
                    </td> <?php
                }

            // current month days
            } else {

                // new table row every monday
                if ($endPrevMonth && $weekday === "Mon") { ?>
                    </tr>
                    <tr> <?php
                }

                // possible that 01 starts on a monday, so we have to "end" our previous month
                if (!$endPrevMonth) {
                    $endPrevMonth = true;
                }

                // check if we are entering a new month, if so want to fill up our current row with new dates if needed
                if ($day === "01" && ($prevDay === "31" || $prevDay === "30" || $prevDay === "29" || $prevDay === "28")) {
                    if ($weekday !== "Mon") {
                        $doNextMonth = true;
                    } else {
                        $endMonth = true;
                    }

                    // if not we fill our cells with current month data
                } else {
                    if (!$doNextMonth) {
                        if (($day < $curday && $curmonth === $month) ||
                            isFeestdag($day, $month) || $weekday === "Mon" || $weekday === "Sun" ||
                            ($_SESSION['barber'] === "Juno" && ($weekday === "Mon" || $weekday === "Wed" || $weekday === "Fri") ||
                            $hasAppointmentOnDate)
                        ) { ?>
                            <td class="calendardateblocked <?=$todayclass?> <?=$filledclass?>" onmouseover="<?=$filledhover?>">
                                <div class="divBox">
                                    <span> <?=$day?> </span>
                                </div>
                            </td> <?php
                        } else { ?>
                            <td class="calendardate cut-selector <?=$todayclass?>">
                                <div class="divBox">
                                    <input type="radio" id="<?=$date?>" class="date-radio" name="date" value="<?=$date?>" onclick="onDateClick(<?=$day?>, <?=$weekday_f?>, <?=$monthname?>, <?=$month?>, <?=$calendar_year?>, 0)" />
                                    <label for="<?=$date?>"> <?=$day?> </label>
                                </div>
                            </td> <?php
                        }
                    }
                }

                // fill up row with days of next month
                if ($doNextMonth) {
                    if ($weekday === "Mon") {
                        $doNextMonth = false;
                        $endMonth = true;
                    } else { ?>
                        <td class="calendardateblocked <?=$todayclass?>">
                            <div class="divBox">
                                <span> <?=$day?> </span>
                            </div>
                        </td> <?php
                    }
                }
            }

            // count up days
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
</body>
</html>