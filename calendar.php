<?php
if(!isset($_SESSION)) {
    session_start();
}

require_once "nlDate.php";
require_once "Barbers.php";

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $starting_day = "$year-$month-1";
    $time = strtotime($starting_day);
} else {
    $month = date("n", $time);
    $year =  date("Y", $time);
}



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


        // setup objects so we can gather information from the barbers
        $Jeroen_ = new Jeroen();
        $Juno_   = new Juno();


        // **************************************
        // loop through our current month
        //
        for ($i = 0; $i < $daysinmonth; $i++) {
            $blocked = false;

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

            // first grab some info on when to block or leave open a date on the calendar
            // check if logged in user already has a appointment on this day
            $hasAppointmentOnDate = false;

            if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
                require_once "connect.php";

                $db = mysqli_connect($host, $user, $pw, $database) or die('Error: ' . mysqli_connect_error());

                $sql = "SELECT
                          *
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

                        if ($stmt->affected_rows > 0) {
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
                $blocked = true;
            } else {
                $filledclass = "";
                $filledhover = "";
            }


            // check if this day needs to be blocked
            $curday = date("d");
            $curmonth = date("n");


            // check availability of barbers
            $isAvailable = true;

            if ($_SESSION['barber'] == "Juno") {
                $isAvailable = $Juno_->isAvailable($weekday);
            }

            if ($_SESSION['barber'] == "Jeroen") {
                $isAvailable = $Jeroen_->isAvailable($weekday);
            }

            // if chosen barber is not available
            if (!$isAvailable) {
                $blocked = true;
            }

            // if day is in the past
            if (($day < $curday && $curmonth === $month))
                $blocked = true;

            // if it's a holiday
            if (isFeestdag($day, $month))
                $blocked = true;

            // if it's a monday or sunday
            if ($weekday === "Mon" || $weekday === "Sun")
                $blocked = true;


            // every monday we need to start a new table row
            if ($weekday === "Mon") { ?>
        </tr>
        <tr>
            <?php
            }

            if ($blocked) {
                ?>
                <td class="calendardateblocked <?= $todayclass ?> <?= $filledclass ?>" onmouseover="<?= $filledhover ?>">
                    <div class="divBox">
                        <span> <?= $day ?> </span>
                    </div>
                </td>
                <?php
            } else {
                ?>
                <td class="calendardate cut-selector <?=$todayclass?>">
                    <div class="divBox">
                        <input type="radio" id="<?=$date?>" class="date-radio" name="date" value="<?=$date?>" onclick="onDateClick(<?=$day?>, <?=$weekday_f?>, <?=$monthname?>, <?=$month?>, <?=$year?>, 0)" />
                        <label for="<?=$date?>"> <?= $day ?> </label>
                    </div>
                </td>
                <?php
            }

            // go up one day
            $time    = strtotime("+1 day", $time);
            $day     = date("d", $time);
            $weekday = date("D", $time);
        }



        // fill the calender with next month data if this month does not end on a sunday
        while ($weekday !== "Mon") {
            ?>
            <td class="calendardateblocked">
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
</body>
</html>