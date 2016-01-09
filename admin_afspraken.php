<?php
require("common.php");
require_once("nlDate.php");
require_once("admincheck.php");

if(isset($_SESSION['user'])) {

    // level check
    $isAdmin = isAdmin();
    if (!$isAdmin) {
        header("Location: forbidden.php");
        die("Redirecting to forbidden.php");
    }

    if (isset($_GET['day']) && isset($_GET['month']) && isset($_GET['year'])) {
        $day = $_GET['day'];
        $month = $_GET['month'];
        $year = intval($_GET['year']);

        $d = strtotime("$year-$month-$day");

        $monthname = nlDate(date("F", $d));
    } else {
        $day = date("d");
        $month = date("m");
        $year = date("Y");
    }

    $date = $year."-".$month."-".$day;

} else {
    header("Location: forbidden.php");
    die("Redirecting to forbidden.php");
}
?>
<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classics Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:700' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<?php
    if (!isset($_GET['p'])) {
?>
<section id="main-page">
    <p id="header-text-header">Afspraken</p>

    <div id="basic-wrapper">
        <div class="ta-left">
            <a href="admin.php">< admin pagina</a>
        </div>

        <div class="white-background">
            <div id="account-text">
                <p class="header-text">Kies Kapper</p>
            </div>

            <section id="basic-wrapper" class="choose-barber">
                <a href="admin_afspraken.php?p=1">Jeroen</a> <br />
                <a href="admin_afspraken.php?p=2">Juno</a> <br />
            </section>
        </div>
    </div>
</section>
<?php
    } else {
        if ($_GET['p'] == 1) {
            $barber = "Jeroen";
        } else {
            $barber = "Juno";
        }
?>
<section id="main-page">
    <p id="header-text-header" class="margin-b-100">Afspraken</p>

    <div id="basic-wrapper">
        <div class="ta-left">
            <a href="admin_afspraken.php">< andere kapper</a>
        </div>

<!--        <div class="white-background">-->
<!--        </div>-->

        <div class="admin-barber-name-wrapper ta-left">
            <p class="header-text admin-barber-name-appointments"><?= $barber ?></p>
        </div>

        <div class="white-background">
            <div id="account-text">
                <p class="header-text admin-kalender-header"><?= nldate(date("l j F Y")) ?></p>
            </div>

            <div class="admin-wrapper-wide margin-t-40">
                <div id="admin-kalender-times">
<?php
                $monthname = date("F");

                $hour = 9;
                $end_hour = 17;
                $didMorningHeader = false;
                $didAfternoonHeader = false;
                $didEveningHeader = false;
                $dayname = date("D", mktime(0, 0, 0, $month, $day, $year));

                if ($dayname === "Thu") {
                    $hour = 11;
                    $end_hour = 17;
                } else if ($dayname === "Sat") {
                    $end_hour = 15;
                }



                // loop start
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

                    if ($hour < 12 && !$didMorningHeader) {
?>
                    <div class="o-m-a-header-wrapper">
                        <p class="o-m-a-header">Ochtend</p>
                    </div>

                    <div class="times-container-day">
<?php
                        $didMorningHeader = true;
                    }

                    if ($hour > 11 && $hour < 18 && !$didAfternoonHeader) {
?>
                    </div>

                    <div class="o-m-a-header-wrapper">
                        <p class="o-m-a-header">Middag</p>
                    </div>

                    <div class="times-container-day">
<?php
                        $didAfternoonHeader = true;
                    }

                    if ($hour > 18 && !$didEveningHeader) {
?>
                    </div>

                    <div class="o-m-a-header-wrapper">
                        <p class="o-m-a-header">Avond</p>
                    </div>

                    <div class="times-container-day">
<?php
                        $didEveningHeader = true;
                    }

                    $mn = "\"" . $monthname . "\"";

                    $curtime   = time();
                    $starttime = mktime($u, $m, 0, $month, $day, $year);
                    $endtime   = mktime($uu, $mm, 0, $month, $day, $year);

                    if ($curtime >= $starttime && $curtime < $endtime) {
                        $isCurrentTimeSlot = "admin-times-container-current";
                    } else {
                        $isCurrentTimeSlot = "";
                    }

                    if ($curtime > $starttime && $isCurrentTimeSlot === "") {
                        $isPast = true;
                    } else {
                        $isPast = false;
                    }

                    if ($isPast) {
                        $class_p = "time-button-taken";
                        $class_i = "times-icon-taken";
                        $class_txt = "time-user-info-past";
                        $img_src = "images/booking/timer_clear2-taken.png";
                    } else {
                        $class_p = "time-button";
                        $class_i = "times-icon";
                        $class_txt = "";
                        $img_src = "images/booking/timer_clear2.png";
                    }
?>
                        <div id="<?=$time1?>|<?=$img_src?>" class="admin-times-container <?=$isCurrentTimeSlot?>" onmouseover="timesContainerHover(this.id);" onmouseout="timesContainerOut(this.id)">
                            <div class="admin-times-time-container">
                                <img id="<?= $time1 ?>" class="admin-times-img <?=$class_i?>" src="<?=$img_src?>">

                                <div>
                                    <p class="<?=$class_p?>"><?= $time1 ?></p><br/>
                                    <p class="<?=$class_p?> small-text-time"><?= $time2 ?></p>
                                </div>
                            </div>

                            <div class="admin-time-appointment-info">
<?php
                    $db = mysqli_connect($host, $user, $pw, $database) or die('Error: ' . mysqli_connect_error());

                    $sql = "SELECT
                              voornaam,
                              achternaam,
                              knipbeurt
                            FROM
                              afspraken
                            WHERE
                              tijd = ?
                            AND
                              datum = ?
                            AND
                              kapper = ?
                            ";

                    if ($stmt = $db->prepare($sql)) {
                        $stmt->bind_param('sss', $time1, $date, $barber);

                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            $stmt->bind_result($vnaam, $anaam, $cut);

                            while ($stmt->fetch()) { ?>
                                <p class="<?=$class_txt?>"><?= $vnaam . " " . $anaam ?></p>
                                <p class="<?=$class_txt?>"><?= ucfirst($cut) ?></p> <?php
                            }
                        } else {
                            // if we are past current time, we disable the option
                            $curtime = time();
                            $timeslot = mktime($hour, $m, 0, $month, $day, $year);
                            if ($curtime >= $timeslot) {

                                // no link to add appointment
?>
                                <p></p>
<?php
                                // link to add appointment
                            } else {
?>
                                <p>
                                    <a href="admin_nieuwe_afspraak.php?t=<?= $time1 ?>&tt=<?= $time2 ?>&d=<?= $date ?>&k=<?= $barber ?>">Voeg afspraak toe</a>
                                </p>
<?php
                            }
                        }

                        $stmt->close();
                    } else {
                        die("Error: 1");
                    }
?>
                            </div>
                        </div>
<?php
                }

                if ($didEveningHeader) {
?>
                </div>
<?php
                }
?>
            </div>
        </div>
    </div>
</section>
<?php
    }
?>

<script src="scripts/admin.js"></script>
<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>