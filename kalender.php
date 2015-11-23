<?php
    // y-m-d
//    $starting_day = date("y-m-d");
    $starting_day = "2015-10-1";
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
    $doFillWithCurrentMonthDays = false;
    $notThisMonthArray = array();
    $prevDay = -1;
    $counter = 0;
    $pweekdayadd = 0;
    $loops = 0;
    do {
        $day = date("d", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));
        $weekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));
        $pweekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)-$counter, date("y",$time)));

        // not current month days
        if ($day === "01" && $weekday !== "Mon" && !$endNotThisMonth) {
            $i = 1;

            do {
                $pday = date("d", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                $pweekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)-$i, date("y",$time)));
                $notThisMonthArray[] = $pday;

                $i++;
                if ($i > 7 || $pweekday === "Mon") {
                    $endNotThisMonth = true;
                }
            }while(!$endNotThisMonth);

            $pdays = count($notThisMonthArray) - 1;
            for ($j = $pdays; $j >= 0; $j--) {
                echo "<td class=\"kalendernotthismonth\"> $notThisMonthArray[$j] </td>";
            }

            if ($pweekday !== "Sun") {
//                $doFillWithCurrentMonthDays = true;

                if ($weekday !== "Sun") {
                    echo "<td class=\"kalenderdatum\"> $day </td>";
                } else {
                    $doFillWithCurrentMonthDays = false;
                }
            }
            // current month days
        } else {
            if ($doFillWithCurrentMonthDays) {

            } else {
                if ($weekday === "Mon") {
                    echo "</tr><tr>";
                }

                if ($day === "01" && ($prevDay === "31" || $prevDay === "30" || $prevDay === "29")) {
                    $endMonth = true;
                } else {
                    echo "<td class=\"kalenderdatum\"> $day </td>";

                    if ($counter > 100) {
                        $endMonth = true;
                    }
                }
            }

            $counter++;
            $prevDay = $day;
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