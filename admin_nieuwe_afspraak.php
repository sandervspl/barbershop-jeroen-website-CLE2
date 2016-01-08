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
} else {
    header("Location: forbidden.php");
    die("Redirecting to forbidden.php");
}


$voornaam   = '';
$achternaam = '';
$cut        = '';
$datum      = '';
$tijd       = '';
$kapper     = '';
$telefoon   = '';

if (isset($_POST['admin-add-appointment-button'])) {
    $ok = true;

    $values = explode("|", $_POST['admin-add-appointment-button']);

    $datum  = $values[0];
    $tijd   = $values[1];
    $kapper = $values[2];

    if (!isset($_POST['voornaam']) || $_POST['voornaam'] === '') {
        $ok = false;
    } else {
        $voornaam = $_POST['voornaam'];
    }

    if (!isset($_POST['achternaam']) || $_POST['achternaam'] === '') {
        $ok = false;
    } else {
        $achternaam = $_POST['achternaam'];
    }

    if (!isset($_POST['cut']) || $_POST['cut'] === '') {
        $ok = false;
    } else {
        $cut = $_POST['cut'];
    }

    if (!isset($_POST['telefoon']) || $_POST['telefoon'] === '') {
        $ok = false;
    } else {
        $telefoon = $_POST['telefoon'];
    }

    if (!isset($datum) || $datum === '') {
        $ok = false;
    }

    if (!isset($tijd) || $tijd === '') {
        $ok = false;
    }

    if (!isset($kapper) || $kapper === '') {
        $ok = false;
    }


    if ($ok) {
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
            $stmt->bind_param('sss', $tijd, $datum, $kapper);

            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $sql = "INSERT INTO
                      afspraken (voornaam, achternaam, datum, tijd, knipbeurt, kapper, telefoon)
                    VALUES
                      (?, ?, ?, ?, ?, ?, ?)
                    ";

                if ($stmt2 = $db->prepare($sql)) {
                    $stmt2->bind_param('sssssss', $voornaam, $achternaam, $datum, $tijd, $cut, $kapper, $telefoon);

                    if ($stmt2->execute()) {
                        header("Location: admin_nieuwe_afspraak.php?p=3");
                    } else {
                        die("error: 2");
                    }

                    $stmt2->close();
                    die("Redirecting to afspraken kalender");
                }
            } else {
                $ok = false;
                echo "<br /> Error: Appointment already exists.";
            }

            $stmt->close();
        } else {
            die("Error: 1");
        }
    }
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
if (isset($_GET['p']) && $_GET['p'] == 3) {
?>
<section id="main-page">
    <p id="header-text-header">Reservering Compleet</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <img id="img-big" class="inline-block" src="images/confirmation/chair.png">
            <div class="bedankt inline-block">
                <p class="header-text-big">Reservering compleet!</p>
                <br />
                <p><a href="admin.php">Terug naar admin pagina</a></p>
            </div>
        </div>
    </div>
</section>
<?php
} else {
?>

<section id="main-page">
    <p id="header-text-header">Afspraak Toevoegen</p>

    <div id="basic-wrapper">
        <div class="white-background">
            <div id="account-text">
                <p class="header-text">
                    <?php if (isset($_GET['d'])) {
                        $date = strtotime($_GET['d']);

                        echo nldate(date("l j F Y", $date));
                    } ?>
                </p>

                <p class="header-text no-margin admin-add-appointment-time">
                    <?php if (isset($_GET['t']) && isset($_GET['tt'])) {
                        echo $_GET['t'] . " - " . $_GET['tt'];
                    } ?>
                </p>
            </div>
        </div>

        <div class="white-background margin-t-10">
            <div id="account-text">
                <p class="header-text">
                    <?php if (isset($_GET['k'])) {
                        echo $_GET['k'];
                    } ?>
                </p>
            </div>

            <div id="admin-add-appointment-wrapper">
                <form id="admin-add-appointment-form" name="admin-add-appointment-form" method="post">
                    <div id="naam-form-element">
                        <fieldset>
                            <legend class="input-text">Naam</legend>
                            <label id="voornaam-label" class="input-text">
                                <input type="text" id="voornaam" class="admin-va-input" name="voornaam"
                                       autofocus="autofocus" placeholder="Voornaam" value="<?= $voornaam ?>">
                            </label>
                            <label id="achternaam-label" class="input-text">
                                <input type="text" id="achternaam" class="admin-va-input" name="achternaam"
                                       placeholder="Achternaam" value="<?= $achternaam ?>">
                            </label>
                        </fieldset>
                    </div>

                    <br/>

                    <div id="telefoon-form-element">
                        <p class="input-text">Telefoon</p>
                        <label id="telefoon-label" class="input-text">
                            <input type="text" id="telefoon" class="" name="telefoon" placeholder="Telefoonnummer"
                                   value="<?= $telefoon ?>">
                        </label>
                    </div>

                    <br/>

                    <div id="knipbeurt-form-element">
                        <p class="input-text">Knipbeurt</p>
                        <label id="admin-radio-hair" class="input-text">
                            <input id="admin-radio-hair" class="admin-radio" type="radio" name="cut" value="haar"/>
                            <span class="admin-radio-txt">Haar</span><br/>
                        </label>
                        <label id="admin-radio-beard" class="input-text">
                            <input id="admin-radio-beard" class="admin-radio" type="radio" name="cut" value="baard"/>
                            <span class="admin-radio-txt">Baard</span><br/>
                        </label>
                        <label id="admin-radio-moustache" class="input-text">
                            <input id="admin-radio-moustache" class="admin-radio" type="radio" name="cut" value="snor"/>
                            <span class="admin-radio-txt">Snor</span><br/>
                        </label>
                        <label id="admin-radio-all" class="input-text">
                            <input id="admin-radio-all" class="admin-radio" type="radio" name="cut" value="alles"/>
                            <span class="admin-radio-txt">Alles</span><br/>
                        </label>
                    </div>

                    <div id="submit-form-element">
                        <button id="admin-add-appointment-button" type="submit" name="admin-add-appointment-button"
                                class="button" value="<?= $_GET['d'] ?>|<?= $_GET['t'] ?>|<?= $_GET['k'] ?>"> Reserveer
                        </button>
                        <br/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<footer>
<?php
}

require_once "footer.php"
?>
</footer>
</body>
</html>