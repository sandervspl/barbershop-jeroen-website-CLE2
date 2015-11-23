<?php
    // y-m-d
//    $starting_day = date("y-m-d");
    $starting_day = "2015-11-1";
    $time = strtotime($starting_day);
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
if (isset($_GET['maand'])) {
    $maand = date("m",$_GET['maand']);
} else {
    $maand = date("m",$time);
}

$prevMonth = date("m", mktime(0,0,0, $maand-1, date("d",$time), date("y",$time)));
$nextMonth = date("m", mktime(0,0,0, $maand+1, date("d",$time), date("y",$time)));
echo "<a href='kalender.php?maand=$prevMonth'>< $prevMonth</a>";
echo "   ", date("m", mktime(0,0,0, $maand, date("d",$time), date("y",$time))), "   ";
echo "<a href='kalender.php?maand=$nextMonth'>$nextMonth ></a>";
?>

<table>
    <tr class="kalenderdag">
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
    $hasPrevMonthDays = false;
    $prevDay = -1;
    $daynr = 0;
    $loops = 0;
    do {
        $day = date("d", mktime(0,0,0, date("m",$time), date("d",$time)+$daynr, date("y",$time)));
        $weekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)+$daynr, date("y",$time)));
        $pweekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)-$daynr, date("y",$time)));

        // not current month days
        if ($day === "01" && $weekday !== "Mon" && !$endNotThisMonth) {
            $i = 1;

            do {
                $pday = date("d", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                $pweekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                $notThisMonthArray[] = $pday;

                $i++;
                if ($i > 7 || $pweekday === "Mon") {
                    $days = count($notThisMonthArray) - 1;
                    for ($j = $days; $j >= 0; $j--) {
                        echo "<td class=\"kalendernotthismonth\"> $notThisMonthArray[$j] </td>";
                    }

                    $starting_day = "2015-11-1";
                    $time = strtotime($starting_day);

                    $endNotThisMonth = true;
                }

                $prevDay = $pday;
            }while(!$endNotThisMonth);

            $hasPrevMonthDays = true;

            // current month days
        } else {
            if (($prevDay === "31" || $prevDay === "30" || $prevDay === "29") && $hasPrevMonthDays) {
                $pweekdaynr = date("N",strtotime($pweekday));

                for ($pweekdaynr; $pweekdaynr < 7; $pweekdaynr++) {
                    echo "<td class=\"kalenderdatum\"> $day </td>";
                }
            } else {
                if ($daynr % 7 == 0) {
                    echo '</tr><tr>';
                }

                if ($day === "01" && ($prevDay === "31" || $prevDay === "30" || $prevDay === "29")) {
                    $endMonth = true;
                } else {
                    echo "<td class=\"kalenderdatum\"> $day </td>";
                    $daynr++;

                    if ($i > 100) {
                        $endMonth = true;
                    }

                    $prevDay = $day;
                }
            }
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