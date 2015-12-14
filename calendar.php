<?php
include_once "nlDate.php";

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
    $starting_day = "$year-$month-1";
    $time = strtotime($starting_day);
} else {
    $month = date("m", $time);
    $year =  date("Y", $time);
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Classic Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<table id="calendar">
    <tr class="calendarday">
        <th>Maa</th>
        <th>Din</th>
        <th>Woe</th>
        <th>Don</th>
        <th>Vri</th>
        <th>Zat</th>
        <th>Zon</th>
    </tr>

    <tr>
        <?php
        function isFeestdag($day, $month) {
            $b = false;
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

        do {
            $day = date("d", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));        // 01-31
            $weekday = date("D", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)));    // Mon-Sun
            $weekday_f =  "\"".date("l", mktime(0,0,0, date("m",$time), date("d",$time)+$counter, date("y",$time)))."\"";  // Monday-Sunday
            $monthname = "\"".date("F", $time)."\"";                                                            // January-December
            $date = date("Y-") . date("m-", $time) . $day;                                                      // 0000-00-00

            $weekday_f = nlDate($weekday_f);
            $monthname = nlDate($monthname);

            $curday = date("d");
            $curmonth = date("m");
            $curdate = date("Y-m-d");

            if ($date === $curdate) {
                $todayclass = "calendartoday";
            } else {
                $todayclass = "";
            }

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
                    echo "<td class='calendardateblocked $todayclass'>";
                    echo '<div class="divBox">';
                    echo "<span> $prevMonthDayArray[$i] </span>";
                    echo "</div></td>";
                }

                // it will always miss day 01 on first row if this is not here. (line 163)
                if ($day < $curday && $curmonth === $month || isFeestdag($day, $month)) {
                    echo "<td class='calendardateblocked $todayclass'>";
                    echo '<div class="divBox">';
                    echo "<span> $day </span>";
                    echo "</div></td>";
                } else if ($weekday !== "Mon" && $weekday !== "Sun") {
                    echo "<td class='calendardate cut-selector $todayclass'>";
                    echo "<div class='divBox'>";
                    echo "<input type='radio' id='$date' class='date-radio' name='date' value='$date' onclick='onDateClick($day, $weekday_f, $monthname, $month, $year)' />";
                    echo "<label for='$date' onclick='onDateClick($day, $monthname, $month, $year)'> $day </label>";
                    echo "</div></td>";
                } else {
                    echo "<td class='calendardate-sun-mon $todayclass'>";
                    echo '<div class="divBox">';
                    echo "<span> $day </span>";
                    echo "</div></div></td>";
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
                        if ($day < $curday && $curmonth === $month || isFeestdag($day, $month)) {
                            echo "<td class='calendardateblocked $todayclass'>";
                            echo '<div class="divBox">';
                            echo "<span> $day </span>";
                            echo "</div></td>";
                        } else if ($weekday !== "Mon" && $weekday !== "Sun") {
                            echo "<td class='calendardate cut-selector $todayclass'>";
                            echo "<div class='divBox'>";
                            echo "<input type='radio' id='$date' class='date-radio' name='date' value='$date' onclick='onDateClick($day, $weekday_f, $monthname, $month, $year)' />";
                            echo "<label for='$date' onclick='onDateClick($day, $monthname, $month, $year)'> $day </label>";
                            echo "</div></td>";
                        } else {
                            echo "<td class='calendardate-sun-mon $todayclass'>";
                            echo '<div class="divBox">';
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
                        echo "<td class='calendardateblocked $todayclass'>";
                        echo '<div class="divBox">';
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
</body>
</html>