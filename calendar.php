<?php
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
    <title>$Title$</title>
    
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
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
</body>
</html>