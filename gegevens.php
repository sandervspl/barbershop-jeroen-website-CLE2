<?php
if(!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['cut']) || !isset($_SESSION['date']) || !isset($_SESSION['time'])) {
    header("Location: reserveer.php");
}

$voornaam = '';
$achternaam = '';
$phone = '';
$email = '';

if (isset($_POST['submit'])) {
    require_once "gegevens_check.php";
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classic Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Bevestig Afspraak</p>
<div id="wrapper">
    <div id="summary-wrapper">
        <p class="header-text">Bestelling</p>
        <div id="summary-wrapper-text">
            <span class="barber-name"><?=$_SESSION['barber']?></span><br/>
                <p id="chosen-month">32 January</p>
            <div id="summary-wrapper-text-time">
                <span id="chosen-time">03:22</span>
                <span id="chosen-etime">04:20</span>
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
    if (isset($_SESSION['user']['username'])) {
        // database connection information
        require_once "connect.php";

        $db =  mysqli_connect($host, $user, $pw, $database) or die('Error: '.mysqli_connect_error());

        $sql = sprintf("SELECT voornaam, achternaam, email, telefoon FROM users WHERE username='%s'",
                        $_SESSION['user']['username']);

        $result = mysqli_query($db, $sql);
        $gegevens = [];
        $voornaam = '';
        $achternaam = '';
        $email = '';
        $telefoon = '';

        while($row = mysqli_fetch_assoc($result)) {
            $gegevens = $row;
        }

        $voornaam   = $gegevens['voornaam'];
        $achternaam = $gegevens['achternaam'];
        $email      = $gegevens['email'];
        $telefoon   = $gegevens['telefoon'];

        mysqli_close($db);
        ?>
        <section id="gegevens-form">
            <div class="white-background">
                <p class="header-text-lobster">Jouw gegevens</p>
                <table>
                    <tr>
                        <td>Naam</td>
                        <td><?= $voornaam . " " . $achternaam ?></td>
                    </tr>
                    <tr>
                        <td>E-Mail</td>
                        <td><?= $email ?></td>
                    </tr>
                    <tr>
                        <td>Telefoon</td>
                        <td><?= $telefoon ?></td>
                    </tr>
                </table>
            </div>
            <div class="gegevens-form-buttons-wrapper">
                <a href="edit_account.php" class="button gegevens-form-button">Wijzig</a>
                <a href="payment.php" class="button gegevens-form-button">Afrekenen</a>
            </div>
        </section>
    <?php
    } else {
    ?>
        <section id="gegevens-form">
            <div class="white-background">
                <form id="mainForm" action="#" method="post">
                    <div class="gegevens">
                            <label class="input-text" for="voornaam">Voornaam</label><br />
                            <input type="text" id="voornaam" class="textinput" name="voornaam" autofocus="autofocus" value="<?=$voornaam?>" />
                            <br />

                            <label class="input-text" for="achternaam">Achternaam</label><br />
                            <input type="text" id="achternaam" class="textinput" name="achternaam" value="<?=$achternaam?>" />
                            <br />

                            <label class="input-text" for="email">E-Mail</label><br/>
                            <input type="email" id="email" class="textinput" name="email" value="<?=$email?>" />
                            <br />

                            <label class="input-text" for="phone">Telefoon</label><br/>
                            <input type="text" id="phone" class="textinput" name="phone" value="<?=$phone?>" />
                    </div>

                    <input type="submit" name="submit" class="button" value="Afrekenen" />
                </form>
            </div>
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