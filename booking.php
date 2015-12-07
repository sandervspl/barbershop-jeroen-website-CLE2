<?php
// grab month & year from url
if (isset($_GET['month']) && isset($_GET['year'])) {
    $m = $_GET['month'];
    $y = $_GET['year'];
    $starting_day = "$y-$m-1";
    $time = strtotime($starting_day);
} else {
    // grab current year/month and start at day 01
    $starting_day = date("Y-m-")."01";
    $time = strtotime($starting_day);
}

// previous, current and next month buttons/label
$monthname = date("F", $time);
$month = date("m", $time);
$year = date("Y", $time);
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
    <div id="summary-header">
    <table class="header-text">
        <tr>
            <th>Wat</th>
            <th>Tijd</th>
            <th>Wie</th>
        </tr>
        <tr>
            <td><img id="cut" class="hair-beard-img" src="images/index/no-hair-no-beard.png"></td>
            <td><img id="cut-time" class="hair-beard-img" src="images/booking/timer_5_min.png"></td>
            <td><span class="barber-name">aaa</span></td>
            <script src="scripts/calendar.js"></script>
            <script type="text/javascript">
                cutSelected();
                barberSelected();
            </script>
        </tr>
    </table>
    </div>

    <div class="month-name">
        <p class="header-text"><?= $monthname; ?></p>
    </div>

<table id="calendar">
    <tr class="calendarday">
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
        <th>Sun</th>
    </tr>

    <tr>

        <?php
        $endMonth = false;
        $endPrevMonth = false;
        $doNextMonth = false;
        $prevDay = -1;
        $counter = 0;

        do {
            $day = date("d", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));        // 01-31
            $weekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));    // Mon-Sun

            // previous month days
            if ($day === "01" && $weekday !== "Mon" && !$endPrevMonth) {
                $i = 1;

                // count backwards until we have a day that is a monday
                do {
                    $prevMonthDay = date("d", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
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
                for ($i = $prevMonthDays; $i >= 0; $i--) {
                    echo "<td class=\"calendardateblocked\">";
                    echo "<div class=\"divBox\">";
                    echo "<span> $prevMonthDayArray[$i] </span>";
                    echo "</div></td>";
                }

                // it will always miss day 01 on first row if this is not here. (line 114)
                if ($weekday !== "Mon" && $weekday !== "Sun") {
                    if ($weekday === "Tue") {
                        echo "<td class=\"calendardate-tue\">";
                    } else {
                        echo "<td class=\"calendardate\">";
                    }
                    echo "<div class=\"divBox\">";
                    echo "<span onclick=\"onDateClick($day, '$monthname', $month, $year)\"> $day </span>";
                    echo "</div></td>";
                } else {
                    echo "<td class=\"calendardate-sun-mon\">";
                    echo "<div class=\"divBox\">";
                    echo "<span> $day </span>";
                    echo "</div></td>";
                }


                // current month days
            } else {

                // new table row every monday
                if ($endPrevMonth && $weekday === "Mon") {
                    echo "</tr><tr>";
                }

                // possible that 01 starts on a monday, so we have to "end" our previous month
                if (!$endPrevMonth) {
                    $endPrevMonth = true;
                };

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
                        if ($weekday !== "Mon" && $weekday !== "Sun") {
                            if ($weekday === "Tue") {
                                echo "<td class=\"calendardate-tue\">";
                            } else {
                                echo "<td class=\"calendardate\">";
                            }
                            echo "<div class=\"divBox\">";
                            echo "<span onclick=\"onDateClick($day, '$monthname', $month, $year)\"> $day </span>";
                            echo "</div></td>";
                        } else {
                            echo "<td class=\"calendardate-sun-mon\">";
                            echo "<div class=\"divBox\">";
                            echo "<span> $day </span>";
                            echo "</div></td>";
                        }
                    }
                }

                // fill up row with days of next month
                if ($doNextMonth) {
                    if ($weekday === "Mon") {
                        $doNextMonth = false;
                        $endMonth = true;
                    } else {
                        echo "<td class=\"calendardateblocked\">";
                        echo "<div class=\"divBox\">";
                        echo "<span> $day </span>";
                        echo "</div></td>";
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

<section id="date-and-time">
    <span id="date-and-time-header" class="header-text"></span>

    <div id="date-and-time-times-container">
        <div id="times-table"><span class="header-text">Loading times...</span></div>
    </div>
</section>


</section>

<footer>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>