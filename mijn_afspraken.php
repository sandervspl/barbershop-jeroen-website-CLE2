<?php
if(!isset($_SESSION)) {
    session_start();
}

// not logged in users shouldn't have access to this page
if(empty($_SESSION['user'])) {
    header("Location: login.php");
    die("Redirecting to login.php");
}

require("common.php");
require_once "connect.php";
require_once "nlDate.php";



function checkValidUser() {
    $host     = 'localhost';
    $user     = 'root';
    $pw       = '';
    $database = 'website';

    $db = mysqli_connect($host, $user, $pw, $database);

    $sql = "SELECT
      voornaam, achternaam, email
    FROM
      users
    WHERE
      username = ?
   ";

    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('s', $_SESSION['user']['username']);

        if ($stmt->execute()) {
            $stmt->store_result();
            $stmt->bind_result($fetch_voornaam, $fetch_achternaam, $fetch_email);

            while($stmt->fetch()) {
                $voornaam   = $fetch_voornaam;
                $achternaam = $fetch_achternaam;
                $email      = $fetch_email;

                $stmt->close();
                return array($voornaam, $achternaam, $email);
            }
        } else {
            $stmt->close();
            return 0;
        }
    }

    return 0;
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
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <div id="basic-wrapper">
        <p id="header-text-header">Mijn Afspraken</p>

        <div class="ta-left">
            <a href="private.php">< opties</a>
        </div>

        <div class="white-background">
            <div id="account-wrapper-wide" class="mijn-afspraken">
                <?php

                /*
                 *
                 * AFSPRAAK VERWIJDEREN
                 *      UITVOERING
                 *
                 */

                if (isset($_GET['p']) && $_GET['p'] == 3 && isset($_GET['a'])) {
                    $db = mysqli_connect($host, $user, $pw, $database);

                    // get user info
                    $voornaam   = '';
                    $achternaam = '';
                    $email      = '';

                    $sql = "SELECT
                              voornaam, achternaam, email
                            FROM
                              users
                            WHERE
                              username = ?
                           ";

                    if ($stmt = $db->prepare($sql)) {
                        $stmt->bind_param('s', $_SESSION['user']['username']);

                        if ($stmt->execute()) {
                            $stmt->store_result();
                            $stmt->bind_result($fetch_voornaam, $fetch_achternaam, $fetch_email);

                            while($stmt->fetch()) {
                                $voornaam   = $fetch_voornaam;
                                $achternaam = $fetch_achternaam;
                                $email      = $fetch_email;
                            }
                        } else {
                            header("Location: mijn_afspraken.php?p=2&a=0&e=1");
                            die("Redirecting to mijn_afspraken.php?p=2&a=0&e=1");
                        }
                    }
                    $stmt->close();

                    // get ID from url
                    $id = $_GET['a'];

                    // collect information from this appointment with this user's info
                    $sql = "SELECT
                              *
                            FROM
                              afspraken
                            WHERE
                              voornaam = ?
                            AND
                              achternaam = ?
                            AND
                              email = ?
                            AND
                              id = ?
                           ";

                    if ($stmt = $db->prepare($sql)) {
                        $stmt->bind_param('sssi', $voornaam, $achternaam, $email, $id);

                        if ($stmt->execute()) {
                            $stmt->store_result();

                            // something went wrong, redirect
                            if ($stmt->num_rows <= 0) {
                                header("Location: mijn_afspraken.php?p=2&a=0&e=2");
                                die("Redirecting to mijn_afspraken.php?p=2&a=0&e=2");
                            }
                        }
                    }
                    $stmt->close();

                    // prepare delete statement and execute
                    $sql = "DELETE FROM
                              afspraken
                            WHERE
                              id = ?
                           ";

                    if ($stmt = $db->prepare($sql)) {
                        $stmt->bind_param('s', $id);

                        if ($stmt->execute()) {

                            // something went wrong, redirect
                            if ($stmt->affected_rows <= 0) {
                                header("Location: mijn_afspraken.php?p=2&a=0&e=3");
                                die("Redirecting to mijn_afspraken.php?p=2&a=0&e=3");
                            }
                        }
                    }
                    $stmt->close();

                    mysqli_close($db);
                ?>
                    <p class="header-text">Afspraak verwijderen</p>
                    <p>Afspraak succesvol verwijderd.</p> <br />
                    <a href="mijn_afspraken.php">Ga terug naar Mijn Afspraken</a>
                <?php
                }


                /*
                 *
                 * AFSPRAAK VERWIJDEREN
                 *    CONFIRMATION
                 *
                 */


                if (isset($_GET['p']) && isset($_GET['a'])) {
                    $db = mysqli_connect($host, $user, $pw, $database);

                    // get user info
                    $voornaam   = '';
                    $achternaam = '';
                    $email      = '';

                    $sql = "SELECT
                              voornaam, achternaam, email
                            FROM
                              users
                            WHERE
                              username = ?
                           ";

                    if ($stmt = $db->prepare($sql)) {
                        $stmt->bind_param('s', $_SESSION['user']['username']);

                        if ($stmt->execute()) {
                            $stmt->store_result();
                            $stmt->bind_result($fetch_voornaam, $fetch_achternaam, $fetch_email);

                            while($stmt->fetch()) {
                                $voornaam   = $fetch_voornaam;
                                $achternaam = $fetch_achternaam;
                                $email      = $fetch_email;
                            }
                        } else {
                            header("Location: mijn_afspraken.php?p=2&a=0&e=1");
                            die("Redirecting to mijn_afspraken.php?p=2&a=0&e=1");
                        }
                    }
                    $stmt->close();

                    // get ID from url
                    $id = $_GET['a'];

                    // only continue if we are allowed to delete this appointment
                    if ($_GET['p'] == 1) {
                        $sql = "SELECT
                                  voornaam, achternaam, datum, tijd, knipbeurt, kapper
                                FROM
                                  afspraken
                                WHERE
                                  voornaam = ?
                                AND
                                  achternaam = ?
                                AND
                                  email = ?
                                AND
                                  id = ?
                               ";

                        if ($stmt = $db->prepare($sql)) {
                            $stmt->bind_param('sssi', $voornaam, $achternaam, $email, $id);

                            if ($stmt->execute()) {
                                $stmt->store_result();
                                $stmt->bind_result($fetch_voornaam, $fetch_achternaam, $fetch_datum, $fetch_tijd, $fetch_knipbeurt, $fetch_kapper);

                                if ($stmt->num_rows > 0) {
                                    while ($stmt->fetch()) {
                                        $originalDate = $fetch_datum;
                                        $date = nlDate(date("l j F", strtotime($originalDate)));

                                        ?>

                                        <p class="header-text">Afspraak verwijderen</p>
                                        <div class="delete-appointment-wrapper">
                                            <p>Weet je zeker dat je deze afspraak wilt verwijderen?</p>
                                            <br/>

                                            <div class="divider-light"></div>

                                            <div class="header-text-small appointment-title">Naam:</div>
                                            <div class="header-text-small appointment-value"><?= ucfirst($fetch_achternaam . " " . $fetch_achternaam) ?></div>
                                            <br/>
                                            <div class="header-text-small appointment-title">Datum:</div>
                                            <div class="header-text-small appointment-value"><?= $date ?></div>
                                            <br/>
                                            <div class="header-text-small appointment-title">Tijd:</div>
                                            <div class="header-text-small appointment-value"><?= $fetch_tijd ?></div>
                                            <br/>
                                            <div class="header-text-small appointment-title">Knipbeurt:</div>
                                            <div class="header-text-small appointment-value"><?= $fetch_knipbeurt ?></div>
                                            <br/>
                                            <div class="header-text-small appointment-title">Kapper:</div>
                                            <div class="header-text-small appointment-value"><?= $fetch_kapper ?></div>
                                            <br />

                                            <div class="divider-light"></div>

                                            <a href="mijn_afspraken.php" class="button gegevens-form-button">Nee</a>
                                            <a href="mijn_afspraken.php?p=3&a=<?=$id?>" class="button gegevens-form-button">Ja</a>
                                        </div>

                                        <?php
                                    }
                                } else {
                                    // something went wrong
                                    header("Location: mijn_afspraken.php?p=2&a=0&e=5");
                                    die("Redirecting to mijn_afspraken.php?p=2&a=0&e=5");
                                }
                            }
                        }
                        $stmt->close();


                    /*
                     *
                     * AFSPRAAK VERWIJDEREN
                     *      MAG NIET
                     *
                     */

                    } else if ($_GET['p'] != 3) {
                ?>
                        <p class="header-text">Afspraak verwijderen</p>
                        <p>U bent niet gemachtigd om dit te doen.</p> <br />
                        <a href="mijn_afspraken.php">Ga terug naar Mijn Afspraken</a>
                <?php
                    }

                    mysqli_close($db);


                    /*
                     *
                     *
                     * AFSPRAAK LIJST
                     *
                     *
                     */
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

                    // look for all apps that are in the past and not set as done
                    $curtime = time();
                    $curdate = date("Y-m-d");

                    $sql = "SELECT
                              voltooid,
                              datum
                            FROM
                              afspraken
                            WHERE
                              voltooid = 0
                            AND
                              datum < ?
                           ";

                    if ($stmt = $db->prepare($sql)) {
                        $stmt->bind_param('s', $curdate);

                        if($stmt->execute()) {
                            $stmt->store_result();

                            while($stmt->fetch()) {
                                $stmt->bind_result($voltooid, $date2);

                                $date3 = strtotime($date2);

                                if ($date3 < $curtime) {

                                    // update every app that is not set as done yet
                                    $sql = "UPDATE
                                              afspraken
                                            SET
                                              voltooid = 1
                                            WHERE
                                              datum < ?
                                            AND
                                              voltooid = 0
                                           ";

                                    if ($stmt2 = $db->prepare($sql)) {
                                        $stmt2->bind_param('s', $curdate);

                                        $stmt2->execute();
                                        $stmt2->close();
                                    }
                                }
                            }
                        }
                    }
                    $stmt->close();



                    // start preparing our apps list
                    $sql = "SELECT
                              email
                            FROM
                              users
                            WHERE
                              username = ?
                           ";

                    if ($stmt3 = $db->prepare($sql)) {
                        $stmt3->bind_param('s', $_SESSION['user']['username']);

                        if ($stmt3->execute()) {
                            $stmt3->store_result();
                            $stmt3->bind_result($em);

                            while ($stmt3->fetch()) {
                                $email = $em;
                            }
                        }
                    }
                    $stmt3->close();
                    ?>

                    <div class="user-appointments-list">
                        <p class="o-m-a-header appointments-header-text">Huidige afspraken</p>

                    <?php
                    // start by showing apps in ascending order that are now or in the future
                    $sql = "SELECT
                              A.id, A.datum, A.tijd, A.knipbeurt, A.kapper
                            FROM
                              afspraken A
                            WHERE
                              A.email
                            IN (
                                select
                                  B.email
                                from
                                  users B
                                where
                                  B.email = ?
                            )
                            AND
                              datum >= ?
                            ORDER BY
                              A.datum ASC, A.tijd ASC
                           ";

                    if ($stmt4 = $db->prepare($sql)) {
                        $stmt4->bind_param('ss', $email, $curdate);

                        if ($stmt4->execute()) {
                            $stmt4->store_result();
                            $stmt4->bind_result($id, $originalDate, $tijd, $knipbeurt, $kapper);

                            while ($stmt4->fetch()) {
                                $date = nlDate(date("l j F", strtotime($originalDate)));

                                $aptime = explode(":", $tijd);
                                $hour = $aptime[0];
                                $min = $aptime[1];

                                $apdate = explode("-", $originalDate);
                                $day = $apdate[2];
                                $month = $apdate[1];
                                $year = $apdate[0];

                                $starttime = mktime($hour, $min, 0, $month, $day, $year);

                                if ($curtime > $starttime) {
                                    $isPast = "appointment-past";
                                } else {
                                    $isPast = "";
                                }
                                ?>
                                <div id="<?=$id?>" class="appointment-info" onmouseover="userInfoHover(this.id)" onmouseout="userInfoOut(this.id)">
                                    <div class="header-text-small appointment-title <?= $isPast ?>">Datum:</div>
                                    <div class="header-text-small appointment-value <?= $isPast ?>"><?= $date ?></div>
                                    <br/>
                                    <div class="header-text-small appointment-title <?= $isPast ?>">Tijd:</div>
                                    <div class="header-text-small appointment-value <?= $isPast ?>"><?= $tijd ?></div>
                                    <br/>
                                    <div class="header-text-small appointment-title <?= $isPast ?>">Knipbeurt:</div>
                                    <div class="header-text-small appointment-value <?= $isPast ?>"><?= $knipbeurt ?></div>
                                    <br/>
                                    <div class="header-text-small appointment-title <?= $isPast ?>">Kapper:</div>
                                    <div class="header-text-small appointment-value <?= $isPast ?>"><?= $kapper ?></div>
                                    <br/>

                                    <div class="verwijder-afspraak">
                                        <a href="mijn_afspraken.php?p=1&a=<?= $id ?>" class="">Verwijder afspraak</a>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <?php
                            }
                        } else {
                            ?>
                            <p>U heeft op dit moment geen afspraken staan.</p>
                            <?php
                        }
                    }
                    $stmt4->close();

                    ?>
                    </div>

                    <div class="user-appointments-list">
                        <p class="o-m-a-header appointments-header-text">Oude afspraken</p>

                    <?php

                    // now we show a list of past apps in desc order
                    $sql = "SELECT
                              A.id, A.datum, A.tijd, A.knipbeurt, A.kapper
                            FROM
                              afspraken A
                            WHERE
                              A.email
                            IN (
                                select
                                  B.email
                                from
                                  users B
                                where
                                  B.email = ?
                            )
                            AND
                              datum < ?
                            ORDER BY
                              A.datum DESC, A.tijd ASC
                           ";

                    if ($stmt5 = $db->prepare($sql)) {
                        $stmt5->bind_param('ss', $email, $curdate);

                        if ($stmt5->execute()) {
                            $stmt5->store_result();
                            $stmt5->bind_result($id, $originalDate, $tijd, $knipbeurt, $kapper);

                            while ($stmt5->fetch()) {
                                $date = nlDate(date("l j F", strtotime($originalDate)));

                                $aptime = explode(":", $tijd);
                                $hour = $aptime[0];
                                $min = $aptime[1];

                                $apdate = explode("-", $originalDate);
                                $day = $apdate[2];
                                $month = $apdate[1];
                                $year = $apdate[0];

                                $starttime = mktime($hour, $min, 0, $month, $day, $year);
                                ?>
                                <div id="<?=$id?>" class="appointment-info" onmouseover="userInfoHover(this.id)" onmouseout="userInfoOut(this.id)">
                                    <div class="header-text-small appointment-title appointment-past">Datum:</div>
                                    <div class="header-text-small appointment-value appointment-past"><?= $date ?></div>
                                    <br/>
                                    <div class="header-text-small appointment-title appointment-past">Tijd:</div>
                                    <div class="header-text-small appointment-value appointment-past"><?= $tijd ?></div>
                                    <br/>
                                    <div class="header-text-small appointment-title appointment-past">Knipbeurt:</div>
                                    <div class="header-text-small appointment-value appointment-past"><?= $knipbeurt ?></div>
                                    <br/>
                                    <div class="header-text-small appointment-title appointment-past">Kapper:</div>
                                    <div class="header-text-small appointment-value appointment-past"><?= $kapper ?></div>
                                    <br/>

                                    <div class="verwijder-afspraak">
                                        <a href="mijn_afspraken.php?p=1&a=<?= $id ?>" class="">Verwijder afspraak</a>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <?php
                            }
                        } else {
                            ?>
                            <p>Er zijn geen oude afspraken gevonden.</p>
                            <?php
                        }
                    }
                    $stmt5->close();
                    ?>
                    </div>
                </div>

                <?php
                }
                ?>
                <br /><br />
            </div>
        </div>
    </div>
</section>

<script src="scripts/select.js"></script>
<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>