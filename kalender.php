<?php
    //$time = time();
    //$time = date("M", time() -  3600 );
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kalender</title>

    <link rel="stylesheet" href="style/style.css">
</head>
<body>
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
$month = date("m", $time);
$year = date("Y", $time);

$prevMonth = date("M", mktime(0,0,0, $month-1, date("d",$time), date("y",$time)));
$nextMonth = date("M", mktime(0,0,0, $month+1, date("d",$time), date("y",$time)));

$prevMonthNr = date("m", mktime(0,0,0, $month-1, date("d",$time), date("y",$time)));
$nextMonthNr = date("m", mktime(0,0,0, $month+1, date("d",$time), date("y",$time)));

$prevYearNr = date("Y", mktime(0,0,0, $month-1, date("d",$time), date("y",$time)));
$nextYearNr = date("Y", mktime(0,0,0, $month+1, date("d",$time), date("y",$time)));

echo "<label class='monthlabel'><a href='kalender.php?month=$prevMonthNr&year=$prevYearNr'> < $prevMonth </a></label>";
echo "<label class='monthlabel'>   ", date("F Y", mktime(0,0,0, $month, date("d",$time), $year)), "   </label>";
echo "<label class='monthlabel'><a href='kalender.php?month=$nextMonthNr&year=$nextYearNr'> $nextMonth > </a></label><br>";
?>

<table>
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
                echo "<td class=\"calendardateblocked\"> $prevMonthDayArray[$i] </td>";
            }

            // it will always miss day 01 on first row if this is not here. (line 114)
            if ($weekday !== "Mon" && $weekday !== "Sun") {
                echo "<td class=\"calendardate\">";
                echo "<div class=\"divBox\">";
                echo "<a href=\"selection_page.php?dag=$day&maand=$month&jaar=$year\"> $day </a>";
                echo "</div></td>";
            } else {
                echo "<td class=\"calendardate-sun-mon\"> $day </td>";
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
                        echo "<td class=\"calendardate\">";
                        echo "<div class=\"divBox\">";
                        echo "<a href=\"selection_page.php?dag=$day&maand=$month&jaar=$year\"> $day </a>";
                        echo "</div></td>";
                    } else {
                        echo "<td class=\"calendardate-sun-mon\"> $day </td>";
                    }
                }
            }

            // fill up row with days of next month
            if ($doNextMonth) {
                if ($weekday === "Mon") {
                    $doNextMonth = false;
                    $endMonth = true;
                } else {
                    echo "<td class=\"calendardateblocked\"> $day </td>";
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