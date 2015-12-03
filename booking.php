<?php
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
        <img src="http://barbershopbarcelona.com/wp-content/uploads/2014/11/thebarbershop-Redondo.png" id="header-logo">
        <span id="header-name">Classic Barbershop Jeroen</span>
    </div>
    <nav id="navigation-background">
        <ul>
            <li><a href="#">one</a></li>
            <li><a href="#">two</a></li>
            <li><a href="#">three</a></li>
            <li><a href="#">four</a></li>
            <li><a href="#">five</a></li>
            <li><a href="#">six</a></li>
        </ul>
    </nav>
</header>

<section id="main-page">
    <p id="summary-text" class="header-text">
        <img id="cut" class="hair-beard-img" src=""> door <span class="barber-name"></span>
    </p>

<script>
    var b = document.getElementById('cut');

    // insert chosen cut type
    switch(window.sessionStorage.cut) {
        case "hair": {
            b.setAttribute('src', 'images/index/yes-hair-no-beard-selected.png');
            break;
        }

        case "beard": {
            b.setAttribute('src', 'images/index/no-hair-yes-beard-selected.png');
            break;
        }

        case "moustache": {
            b.setAttribute('src', 'images/index/no-hair-no-beard-yes-moustache-selected.png');
            break;
        }

        case "all": {
            b.setAttribute('src', 'images/index/yes-hair-yes-beard-selected.png');
            break;
        }

        default: {
            b.setAttribute('src', 'images/index/no-hair-no-beard.png');
        }
    }

    // insert chosen barber name
    document.querySelector('.barber-name').innerHTML = window.sessionStorage.barber;
</script>

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
?>

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
                    echo "<td class=\"calendardateblocked\"> $prevMonthDayArray[$i] </td>";
                }

                // it will always miss day 01 on first row if this is not here. (line 114)
                if ($weekday !== "Mon" && $weekday !== "Sun") {
                    echo "<td class=\"calendardate\">";
                    echo "<div class=\"divBox\">";
                    echo "<span> $day </span>";
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
                            echo "<span onclick=\"onDateClick()\"> $day </span>";
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

<p id="booking-date" class="header-text"></p>

</section>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>