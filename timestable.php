<?php
$host     = 'localhost';
$user     = 'root';
$pw       = '';
$database = 'website';

$db =  mysqli_connect($host, $user, $pw, $database) or die('Error: '.mysqli_connect_error());
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">

    <title>Classic Barbershop Jeroen</title>

    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php
if (isset($_GET['month']) && isset($_GET['year']) && isset($_GET['day'])) {
    $day = $_GET['day'];
    $month = $_GET['month'];
    $year = $_GET['year'];
} else {
    $day = date("d");
    $month = date("m");
    $year = date("Y");
}

$date = $year."-".$month."-".$day;
$hour = 9;
$end_hour = 17;

$dayname = date("D", mktime(0,0,0, $month, $day, $year));
if ($dayname === "Thu") {
    $hour = 11;
    $end_hour = 17;
} else if ($dayname === "Sat") {
    $end_hour = 15;
}

$didMorningHeader = false;
$didAfternoonHeader = false;

for ($minute = 0; $minute <= $end_hour; $minute++) {
    if ($minute % 2 == 0) {
        if ($minute > 0) {
            $hour++;
        }

        $m = "00";
    }

    if ($minute % 2) {
        $m = "30";
    }

    if ($hour < 10) {
        $u = "0" . $hour;
    } else {
        $u = $hour;
    }

    $time1 = $u . ":" . $m;
    if ($m === "30") {
        $uu = $u + 1;
        $mm = "00";
    } else {
        $uu = $u;
        $mm = "30";
    }
    $time2 = $uu . ":" . $mm;

    $sql = sprintf("SELECT * FROM afspraken WHERE datum='%s' AND tijd='%s'",
        mysqli_real_escape_string($db, $date),
        mysqli_real_escape_string($db, $time1));
    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        $class = "time-taken";
        $class_i = "times-icon-taken";
    } else {
        $class = "time-open";
        $class_i = "times-icon";
    }

    if ($hour < 12 && !$didMorningHeader) { ?>
        <p class="header-text">Morning</p>
        <?php
        $didMorningHeader = true;
    }

    if ($hour > 11 && $hour < 18 && !$didAfternoonHeader) { ?>
        <p class="header-text">Afternoon</p>
        <?php
        $didAfternoonHeader = true;
    }
    ?>
    <div class="times-container">
        <img id=<?=$time1?> class="<?=$class_i?>" src="images/booking/timer_30_min.png" onclick="onTimeClick(this.id)">
        <div>
            <p class="<?=$class?>"><?= $time1 ?></p><br>
            <p class="<?=$class?>"><?= $time2 ?></p>
        </div>
    </div>

    <?php
}

mysqli_close($db);
?>
</body>
</html>