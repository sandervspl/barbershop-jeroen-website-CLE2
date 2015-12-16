<?php
if(!isset($_SESSION)) {
    session_start();
}

require_once "session_variables_check.php";

if (!$ok) {
    header ("Location: error.php");
}
?>
<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classic Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <div id="main-header">
        <a href="index.php"><img src="images/other/bblogo.png" id="header-logo"></a>
    </div>
    <nav id="navigation-background">
        <div class="navigation-helper">
            <ul>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="index.php">Over Ons</a></li>
                <li><a href="reserveer.php">Reserveer</a></li>
                <li>
                    <?php if (isset($_SESSION['user']['username'])) { ?>
                        <a href="login/private.php" id="login-button">[<?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>]</a>
                    <?php } else { ?>
                        <a href="login/login.php" id="login-button">Login</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </nav>
</header>

<section id="main-page">
    <p id="header-text-header">Reservering Compleet</p>
    <img id="img-big" src="images/confirmation/chair.png">
    <p class="header-text-big">Bedankt voor het reserveren!</p>
    <p>Tot dan!</p>
</section>

<footer>
</footer>

<script src="scripts/select.js"></script>
</body>
</html>