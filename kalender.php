<?php
    // y-m-d
//    $starting_day = date("y-m-d");

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
if (isset($_GET['month']) && isset($_GET['year'])) {
    $m = $_GET['month'];
    $y = $_GET['year'];
    $starting_day = "$y-$m-1";
    $time = strtotime($starting_day);
} else {
    $starting_day = "2020-11-1";
    $time = strtotime($starting_day);
}

$maand = date("m", $time);
$year = date("Y", $time);

$prevMonth = date("M", mktime(0,0,0, $maand-1, date("d",$time), date("y",$time)));
$nextMonth = date("M", mktime(0,0,0, $maand+1, date("d",$time), date("y",$time)));

$prevMonthNr = date("m", mktime(0,0,0, $maand-1, date("d",$time), date("y",$time)));
$nextMonthNr = date("m", mktime(0,0,0, $maand+1, date("d",$time), date("y",$time)));

$prevYearNr = date("Y", mktime(0,0,0, $maand-1, date("d",$time), date("y",$time)));
$nextYearNr = date("Y", mktime(0,0,0, $maand+1, date("d",$time), date("y",$time)));

echo "<label class='monthlabel'><a href='kalender.php?month=$prevMonthNr&year=$prevYearNr'> < $prevMonth </a></label>";
echo "<label class='monthlabel'>   ", date("F Y", mktime(0,0,0, $maand, date("d",$time), $year)), "   </label>";
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
    $notThisMonthArray = array();
    $prevDay = -1;
    $counter = 0;
    $loops = 0;

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
            for ($j = $prevMonthDays; $j >= 0; $j--) {
                echo "<td class=\"kalenderdateblocked\"> $prevMonthDayArray[$j] </td>";
            }

            // it will always miss day 01 on first row if this is not here. (line 108)
            echo "<td class=\"calendardate\"> $day </td>";


        // current month days
        } else {

            // possible that 01 starts on a monday, so we have to "end" our previous month
            if (!$endPrevMonth) {
                $endPrevMonth = true;
            };

            // new table row every monday
            if ($weekday === "Mon") {
                echo "</tr><tr>";
            }

            // check if we are entering a new month, if so we stop looping
            if ($day === "01" && ($prevDay === "31" || $prevDay === "30" || $prevDay === "29" || $prevDay === "28")) {
                $endMonth = true;
            } else {
                echo "<td class=\"calendardate\"> $day </td>";

                // loop escaper
                if ($counter > 100) {
                    $endMonth = true;
                }
            }
        }

        // count up our current month days
        if ($endPrevMonth) {
            $prevDay = $day;
            $counter++;
        }

        // loop escaper
        $loops++;
        if ($loops > 100) {
            $endMonth = true;
        }
    }while(!$endMonth);
    ?>
</table>

</body>
</html>