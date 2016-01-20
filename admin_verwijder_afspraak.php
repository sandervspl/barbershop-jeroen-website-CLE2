<?php
require_once "common.php";
require_once "User.php";
require_once "nlDate.php";

?>
<!DOCTYPE HTML>
<html lang="en">
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
        <p id="header-text-header">Afspraak</p>

        <div class="ta-left">
            <a href="private.php">< opties</a>
        </div>

        <div class="white-background">
            <div id="account-wrapper-wide" class="mijn-afspraken">

<?php
$user_ = new User;
$isAdmin = $user_->getUserLvl();

// redirect if not admin or no id is set
if (!$isAdmin || !isset($_GET['id'])) {
    header("Location: index.php?e=5");
    die("Redirecting");
}





/*
 *
 * AFSPRAAK VERWIJDEREN
 *    CONFIRMATION
 *
 */

if (isset($_GET['p']) && $_GET['p'] == 1) {
    $db = mysqli_connect($host, $user, $pw, $database);

    // get ID from url
    $id = $_GET['id'];

    $sql = "SELECT
              voornaam, achternaam, datum, tijd, knipbeurt, kapper
            FROM
              afspraken
            WHERE
              id = ?
           ";

    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('i', $id);

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
                        <div
                            class="header-text-small appointment-value"><?= ucfirst($fetch_voornaam . " " . $fetch_achternaam) ?></div>
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
                        <br/>

                        <div class="divider-light"></div>

                        <a href="admin_nieuwe_afspraak_kalender.php" class="button gegevens-form-button">Nee</a>
                        <a href="admin_verwijder_afspraak.php?id=<?=$id?>&p=2" class="button gegevens-form-button">Ja</a>
                    </div>

                    <?php
                }
            } else {
                // something went wrong
                header("Location: index.php?e=3");
                die("Redirecting");
            }
        }
    }
    $stmt->close();

    mysqli_close($db);
}





/*
 *
 * AFSPRAAK VERWIJDEREN
 *
 */

if (isset($_GET['p']) && $_GET['p'] == 2) {
    $db = mysqli_connect($host, $user, $pw, $database);

    // get ID from url
    $id = $_GET['id'];

    // collect information from this appointment with this user's info
    $sql = "SELECT
              *
            FROM
              afspraken
            WHERE
              id = ?
            ";

    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            $stmt->store_result();

            // something went wrong, redirect
            if ($stmt->num_rows <= 0) {
                header("Location: index.php?e=1");
                die("Redirecting");
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
                header("Location: index.php?e=2");
                die("Redirecting");
            }
        }
    }
    $stmt->close();

    mysqli_close($db);
    ?>

    <p class="header-text">Afspraak verwijderen</p>
    <p>Afspraak succesvol verwijderd.</p> <br />
    <a href="admin_nieuwe_afspraak_kalender.php">Ga terug naar afspraken kalender</a>
    <?php
}
?>
            </div>
        </div>
    </div>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>