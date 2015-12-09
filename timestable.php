<?php
session_start();

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

$monthname = date("F");

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
$didEveningHeader = false;

for ($i = 0; $i <= $end_hour; $i++) {
    if ($i % 2 == 0) {
        if ($i > 0) {
            $hour++;
        }

        $m = "00";
    }

    if ($i % 2) {
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

    // lunch break
    if ($hour === 13) {
        continue;
    }

    $host     = 'localhost';
    $user     = 'root';
    $pw       = '';
    $database = 'website';
    $db =  mysqli_connect($host, $user, $pw, $database) or die('Error: '.mysqli_connect_error());

    $sql = sprintf("SELECT * FROM afspraken WHERE datum='%s' AND tijd='%s'",
        mysqli_real_escape_string($db, $date),
        mysqli_real_escape_string($db, $time1));
    $result = mysqli_query($db, $sql);

    mysqli_close($db);

    if ($hour < 12 && !$didMorningHeader) { ?>
        <div id="morning-header">
            <p class="header-text">Ochtend</p>
        </div>
        <?php
        $didMorningHeader = true;
    }

    if ($hour > 11 && $hour < 18 && !$didAfternoonHeader) { ?>
        <div id="afternoon-header">
            <p class="header-text">Middag</p>
        </div>
        <?php
        $didAfternoonHeader = true;
    }

    if ($hour > 18 && !$didEveningHeader) { ?>
        <div id="evening-header">
            <p class="header-text">Avond</p>
        </div>
        <?php
        $didEveningHeader = true;
    }

    if (mysqli_num_rows($result) > 0) {
        $class_p = "time-button-taken";
        $class_i = "times-icon-taken";
        $class_d = "times-container-taken";
        $func1 = 0;
        $func2 = 0;
        $img_src = "images/booking/timer_clear2-taken.png";
        $isDisabled = "disabled";
    } else {
        $class_p = "time-button";
        $class_i = "times-icon";
        $class_d = "times-container";
        $func1 = "\"" . $time1 . "\"";  // add "" around data to avoid syntax error in onTimeClick() parameters
        $func2 = "\"" . $time2 . "\"";
        $img_src = "images/booking/timer_clear2.png";
        $isDisabled = "";
    }

    $mn = "\"" . $monthname . "\"";
    ?>

    <div id=<?=$time1?> class=<?=$class_d?> onclick='onTimeClick(<?=$func1?>, <?=$func2?>, <?=$mn?>)'>
        <img id=<?=$time1?> class="<?=$class_i?>" src=<?=$img_src?> />
        <div>
            <button id="<?=$time1?>" type="submit" name="time" class="<?=$class_p?>" value="<?=$time1?>" <?=$isDisabled?>><?= $time1 ?></button><br />
            <script src="scripts/select.js"></script>
            <script type="text/javascript">lockButton("time-button-taken")</script>

            <p class="<?=$class_p?>"><?= $time2 ?></p>
        </div>
    </div>
    <?php
}
?>

<script src="scripts/select.js"></script>
</body>
</html>