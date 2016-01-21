<?php
if(!isset($_SESSION)) {
    session_start();
}

// database connection information
require_once "connect.php";

if (!isset($_SESSION['cut']) || !isset($_SESSION['date']) || !isset($_SESSION['time'])) {
    header("Location: reserveer.php");
    die("Redirecting");
}

// check if user already has an appointment at this time
// if they are not logged in then the calendar will not block dates
// logging in at this page will allow them to make an appointment anyway
// and we need to prevent that
if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    require_once "connect.php";

    $db = mysqli_connect($host, $user, $pw, $database) or die('Error: ' . mysqli_connect_error());

    $hasAppointmentOnDate = false;

    $sql = "SELECT
              *
            FROM
              afspraken
            WHERE
              email = ?
            AND
              datum >= ?
            AND
              datum = ?
            LIMIT
              1
           ";

    if ($stmt = $db->prepare($sql)) {
        $stmt->bind_param('sss', $_SESSION['user']['email'], date("Y-m-d"), $_SESSION['date']);

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->affected_rows > 0) {
                $hasAppointmentOnDate = true;
            }
        }
        $stmt->close();
    }
    mysqli_close($db);

    // redirect
    if ($hasAppointmentOnDate) {
        $_SESSION['error'] = "hasAppointmentOnDate";

        header("Location: booking.php");
        die("Redirecting");
    }
}


$firstname = '';
$lastname  = '';
$phone     = '';
$email     = '';

if (isset($_POST['submit'])) {
    require_once "gegevens_check.php";
}
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
    <p id="header-text-header">Bevestig Afspraak</p>
<div id="wrapper">
    <div id="summary-wrapper">
        <p class="header-text">Reservering</p>

        <div id="summary-wrapper-text">
            <div id="summary-barbername-wrapper">
                <span class="barber-name"><?=htmlentities($_SESSION['barber'])?></span>
            </div>

            <div id="summary-datetime-wrapper">
                <p id="chosen-month">32 januari</p>

                <div id="summary-wrapper-text-time">
                    <span id="chosen-time">03:22</span>
                    <span id="chosen-etime">04:20</span>
                </div>
            </div>
        </div>
        <div id="summary-wrapper-icon">
            <img id="cut" class="hair-beard-img" src="images/index/no-hair-no-beard.png">
        </div>
        <script src="scripts/select.js"></script>
        <script type="text/javascript">
            cutSelected();
            timeSelected();
            monthSelected();
        </script>
    </div>

    <?php
    if (isset($_SESSION['user'])) {
        $firstname = $_SESSION['user']['voornaam'];
        $lastname  = $_SESSION['user']['achternaam'];
        $email     = $_SESSION['user']['email'];
        $phone     = $_SESSION['user']['telefoon'];

        ?>
        <section id="gegevens-form">
            <div class="white-background">
                <p class="header-text-lobster">Jouw gegevens</p>
                    <table>
                        <tr>
                            <td>Naam</td>
                            <td class="capitalize"><?= htmlentities($firstname) . " " . htmlentities($lastname) ?></td>
                        </tr>
                        <tr>
                            <td>E-Mail</td>
                            <td><?= $email ?></td>
                        </tr>
                        <tr>
                            <td>Telefoon</td>
                            <td><?= $phone ?></td>
                        </tr>
                    </table>
                    <br />

                    <a href="edit_account.php?location=<?=urlencode($_SERVER['REQUEST_URI'])?>" class="gegevens-form-button">Wijzig</a>
                </div>

            <form id="mainForm" action="#" method="post">
                <div class="gegevens-form-buttons-wrapper">
                    <input type="submit" name="submit" class="button" value="Afrekenen" />
                </div>
            </form>
        </section>
    <?php
    } else {
    ?>
        <section id="gegevens-form">
            <div class="gegevens">
                <div class="white-background">
                    <a href="login.php?location=<?=urlencode($_SERVER['REQUEST_URI'])?>" id="login-button" class="button">Login</a>
                </div>
            </div>

            <p class="header-text-small of">of</p>

            <form id="mainForm" action="#" method="post">
                <div class="gegevens">
                    <div class="white-background">
                        <label class="input-text" for="voornaam">Voornaam *</label><br />
                        <input type="text" id="voornaam" class="textinput" name="voornaam" autofocus="autofocus" value="<?=htmlentities($firstname)?>" />
                        <br />

                        <label class="input-text" for="achternaam">Achternaam *</label><br />
                        <input type="text" id="achternaam" class="textinput" name="achternaam" value="<?=htmlentities($lastname)?>" />
                        <br />

                        <label class="input-text" for="email">E-Mail *</label><br/>
                        <input type="email" id="email" class="textinput" name="email" value="<?=htmlentities($email)?>" />
                        <br />

                        <label class="input-text" for="phone">Telefoon *</label><br/>
                        <input type="text" id="phone" class="textinput" name="phone" placeholder="01234567890" value="<?=htmlentities($phone)?>" />

                        <input type="submit" name="submit" class="button" value="Reserveer" />
                    </div>
                </div>
            </form>
        </section>
<?php } ?>
</div>

</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>

<script src="scripts/calendar.js"></script>
<script src="scripts/select.js"></script>
</body>
</html>