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
$monthname = date("F", $time);
$month = date("m", $time);
$year = date("Y", $time);
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
        <a href="index_.php"><img src="http://barbershopbarcelona.com/wp-content/uploads/2014/11/thebarbershop-Redondo.png" id="header-logo"></a>
        <span id="header-name">Classic Barbershop Jeroen</span>
    </div>
    <nav id="navigation-background">
        <div class="navigation-helper">
            <ul>
                <li><a href="#">Contact</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Reserveer</a></li>
            </ul>
        </div>
    </nav>
</header>

<section id="main-page">
    <div id="summary-header">
    <table class="header-text">
        <tr>
            <th>Wat</th>
            <th>Tijd</th>
            <th>Wie</th>
        </tr>
        <tr>
            <td><img id="cut" class="hair-beard-img" src="images/index/no-hair-no-beard.png"></td>
            <td><img id="cut-time" class="hair-beard-img" src="images/booking/timer_5_min.png"></td>
            <td><span class="barber-name">aaa</span></td>
            <script src="scripts/calendar.js"></script>
            <script type="text/javascript">
                cutSelected();
                barberSelected();
            </script>
        </tr>
    </table>
    </div>

    <div class="month-name">
        <p class="header-text"><?= $monthname; ?></p>
    </div>

    <!--  calendar  -->
    <?php include_once "calendar.php";?>

    <!--  clicked date from calendar  -->
    <section id="date-and-time">
        <span id="date-and-time-header" class="header-text"></span>

        <!--  contains all times from that day  -->
        <div id="date-and-time-times-container">

            <!--  all times here come from timestable.php via AJAX code in calendar.js  -->
            <div id="times-table"><span class="header-text">Loading times...</span></div>
        </div>
    </section>
</section>

<footer>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>