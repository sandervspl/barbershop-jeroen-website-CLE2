<?php
if(!isset($_SESSION)) {
    session_start();
}

// not logged in users shouldn't have access to this page
if(empty($_SESSION['user'])) {
    header("Location: login.php");
    die("Redirecting to login.php");
}

require_once "nlDate.php";
require_once "connect.php";
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
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Mijn Afspraken</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <div id="account-wrapper-wide" class="mijn-afspraken">
                <?php
                if (isset($_GET['p']) && $_GET['p'] == 3 && isset($_GET['a'])) {
                    require("common.php");

                    $db = mysqli_connect($host, $user, $pw, $database);

                    // check again if we are actually allowed to do this
                    $sql = sprintf("SELECT voornaam, achternaam, email FROM users WHERE username='%s'",
                        mysqli_real_escape_string($db, $_SESSION['user']['username']));

                    $result = mysqli_query($db, $sql);
                    $userinfo = mysqli_fetch_row($result);

                    $id = $_GET['a'];

                    $sql = sprintf("SELECT * FROM afspraken WHERE voornaam='%s' AND achternaam='%s' AND email='%s' AND id='%s'",
                        mysqli_real_escape_string($db, $userinfo[0]),
                        mysqli_real_escape_string($db, $userinfo[1]),
                        mysqli_real_escape_string($db, $userinfo[2]),
                        $id);

                    $result = mysqli_query($db, $sql);
                    $r = (mysqli_num_rows($result) > 0) ? true : false;

                    // if we are not allowed then go to error page
                    if (!$r) {
                        header("Location: mijn_afspraken.php?p=2&a=0");
                        die("Redirecting to mijn_afspraken.php?p=2&a=0");
                    }

                    // prepare delete statement
                    $sql = sprintf("DELETE FROM afspraken WHERE id='%s'",
                        mysqli_real_escape_string($db, $id));

                    // execute it
                    mysqli_query($db, $sql);

                    // see if we succeeded or not
                    $re = (mysqli_affected_rows($db) > 0) ? true : false;

                    mysqli_close($db);

                    // if not, redirect to error page
                    if (!$re) {
                        header("Location: mijn_afspraken.php?p=2&a=0");
                        die("Redirecting to mijn_afspraken.php?p=2&a=0");
                    }
                ?>
                    <p class="header-text">Afspraak verwijderen</p>
                    <p>Afspraak succesvol verwijderd.</p> <br />
                    <a href="mijn_afspraken.php">Ga terug naar Mijn Afspraken</a>
                <?php
                }

                if (isset($_GET['p']) && isset($_GET['a'])) {
                    $db = mysqli_connect($host, $user, $pw, $database);

                    $sql = sprintf("SELECT voornaam, achternaam, email FROM users WHERE username='%s'",
                        mysqli_real_escape_string($db, $_SESSION['user']['username']));

                    $result = mysqli_query($db, $sql);
                    $userinfo = mysqli_fetch_row($result);

                    $id = $_GET['a'];

                    $sql = sprintf("SELECT * FROM afspraken WHERE voornaam='%s' AND achternaam='%s' AND email='%s' AND id='%s'",
                        mysqli_real_escape_string($db, $userinfo[0]),
                        mysqli_real_escape_string($db, $userinfo[1]),
                        mysqli_real_escape_string($db, $userinfo[2]),
                        $id);

                    $result = mysqli_query($db, $sql);
                    $r = (mysqli_num_rows($result) > 0) ? true : false;

                    // only continue if we are allowed to delete this appointment
                    if ($r && $_GET['p'] == 1) {
                        $db = mysqli_connect($host, $user, $pw, $database);

                        $sql = sprintf("SELECT datum, tijd, knipbeurt, kapper FROM afspraken WHERE id='%s'",
                        mysqli_real_escape_string($db, $id));

                        $result = mysqli_query($db, $sql);

                        // if appointment is not found then redirect to error page
                        if (!$result) {
                            header("Location: mijn_afspraken.php?p=2&a=0");
                        } else {
                            $appointment = mysqli_fetch_row($result);

                            $originalDate = $appointment[0];
                            $date = nlDate(date("l j F", strtotime($originalDate)));
                            ?>

                            <p class="header-text">Afspraak verwijderen</p>
                            <div class="delete-appointment-wrapper">
                                <p>Weet je zeker dat je deze afspraak wilt verwijderen?</p>
                                <br/>

                                <div class="divider-light"></div>

                                <div class="header-text-small appointment-title">Datum:</div>
                                <div class="header-text-small appointment-value"><?= $date ?></div>
                                <br/>
                                <div class="header-text-small appointment-title">Tijd:</div>
                                <div class="header-text-small appointment-value"><?= $appointment[1] ?></div>
                                <br/>
                                <div class="header-text-small appointment-title">Knipbeurt:</div>
                                <div class="header-text-small appointment-value"><?= $appointment[2] ?></div>
                                <br/>
                                <div class="header-text-small appointment-title">Kapper:</div>
                                <div class="header-text-small appointment-value"><?= $appointment[3] ?></div>
                                <br />

                                <div class="divider-light"></div>

                                <a href="mijn_afspraken.php" class="button gegevens-form-button">Nee</a>
                                <a href="mijn_afspraken.php?p=3&a=<?=$id?>" class="button gegevens-form-button">Ja</a>
                            </div>
                <?php
                        }
                    } else if ($_GET['p'] != 3) {
                ?>
                        <p class="header-text">Afspraak verwijderen</p>
                        <p>U bent niet gemachtigd om dit te doen.</p> <br />
                        <a href="mijn_afspraken.php">Ga terug naar Mijn Afspraken</a>
                <?php
                    }

                    mysqli_close($db);
                } else {
                ?>

                <div id="account-image" class="calendar-img">
                    <img src="images/login/calendar.png">
                </div>

                <div id="account-text">
                    <span class="header-text-lobster"><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <br /><br /><br />

                    <?php
                    $db = mysqli_connect($host, $user, $pw, $database);

                    $sql = sprintf("SELECT email FROM users WHERE username='%s'",
                                    mysqli_real_escape_string($db, $_SESSION['user']['username']));

                    $result = mysqli_query($db, $sql);
                    $row = mysqli_fetch_row($result);
                    $email = $row[0];

                    $sql = sprintf("SELECT A.id, A.datum, A.tijd, A.knipbeurt, A.kapper FROM afspraken A WHERE A.email in (select B.email from users B where B.email='%s') ORDER BY A.datum",
                                    mysqli_real_escape_string($db, $email)
                        );

                    $result = mysqli_query($db, $sql);
                    $re = (mysqli_num_rows($result) > 0) ? true : false;

                    if (!$re) {
                        ?>
                        <p>U heeft op dit moment geen afspraken staan.</p>
                        <?php
                    }

                    $appointments = [];

                    while($row = mysqli_fetch_assoc($result)) {
                        $appointments[] = $row;
                    }

                    foreach ($appointments as $appointment) {
                        $id = $appointment['id'];
                        $originalDate = $appointment['datum'];
                        $date = nlDate(date("l j F", strtotime($originalDate)));
                        ?>
                        <div class="header-text-small appointment-title">Datum: </div>
                        <div class="header-text-small appointment-value"><?= $date ?></div>
                        <br />
                        <div class="header-text-small appointment-title">Tijd: </div>
                        <div class="header-text-small appointment-value"><?= $appointment['tijd'] ?></div>
                        <br />
                        <div class="header-text-small appointment-title">Knipbeurt: </div>
                        <div class="header-text-small appointment-value"><?= $appointment['knipbeurt'] ?></div>
                        <br />
                        <div class="header-text-small appointment-title">Kapper: </div>
                        <div class="header-text-small appointment-value"><?= $appointment['kapper'] ?></div>
                        <br/><br />


                        <div class="verwijder-afspraak">
                            <a href="mijn_afspraken.php?p=1&a=<?=$id?>" class="">Verwijder afspraak</a>
                        </div>
                        <br/><br />

                        <div class="divider-light"></div>
                        <?php
                    }
                    ?>
                </div>

                <?php
                mysqli_close($db);
                }
                ?>
                <br /><br />
            </div>
        </div>
    </div>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>