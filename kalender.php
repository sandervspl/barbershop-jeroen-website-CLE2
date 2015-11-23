<?php
    // y-m-d
//    $starting_day = date("y-m-d");
    $starting_day = "2015-11-1";
    $time = strtotime($starting_day);
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
if (isset($_GET['month'])) {
    $maand = date("m",$_GET['month']);
} else {
    $maand = date("m",$time);
}

$prevMonth = date("m", mktime(0,0,0, $maand-1, date("d",$time), date("y",$time)));
$nextMonth = date("m", mktime(0,0,0, $maand+1, date("d",$time), date("y",$time)));
echo "<a href='kalender.php?month=$prevMonth'>< $prevMonth</a>";
echo "   ", date("m", mktime(0,0,0, $maand, date("d",$time), date("y",$time))), "   ";
echo "<a href='kalender.php?month=$nextMonth'>$nextMonth ></a>";
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
    $endNotThisMonth = false;
    $notThisMonthArray = array();
    $prevDay = -1;
    $counter = 0;
    $loops = 0;
    do {
        $day = date("d", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));
        $weekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));
        $pweekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)-$counter, date("y",$time)));

        // not current month days
        if ($day === "01" && $weekday !== "Mon" && !$endNotThisMonth) {
            $i = 1;

            do {
                $prevMonthDay = date("d", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                $prevMonthWeekDay = date("D", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                $prevMonthDayArray[] = $prevMonthDay;

                $i++;
                if ($i > 7 || $prevMonthWeekDay === "Mon") {
                    $endNotThisMonth = true;
                }
            }while(!$endNotThisMonth);

            $prevMonthDays = count($prevMonthDayArray) - 1;
            for ($j = $prevMonthDays; $j >= 0; $j--) {
                echo "<td class=\"kalenderdateblocked\"> $prevMonthDayArray[$j] </td>";
            }

            if ($prevMonthWeekDay !== "Sun") {
                echo "<td class=\"calendardate\"> $day </td>";
            }

            // current month days
        } else {
            if (!$endNotThisMonth) {
                $endNotThisMonth = true;
            };


                if ($weekday === "Mon") {
                    echo "</tr><tr>";
                }

                if ($day === "01" && ($prevDay === "31" || $prevDay === "30" || $prevDay === "29" || $prevDay === "28")) {
                    $endMonth = true;
                } else {
                    echo "<td class=\"calendardate\"> $day </td>";

                    if ($counter > 100) {
                        $endMonth = true;
                    }
                }
//            }
        }

        if ($endNotThisMonth) {
            $prevDay = $day;
            $counter++;
        }

        $loops++;
        if ($loops > 100) {
            $endMonth = true;
        }
    }while(!$endMonth);
    ?>
</table>

</body>
</html>