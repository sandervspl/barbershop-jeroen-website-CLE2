<?php
if(!isset($_SESSION)) {
    session_start();
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
<div id="main-header">
    <a href="index.php"><img src="images/other/bblogo.png" id="header-logo"></a>
</div>
<nav id="navigation-background">
    <div class="navigation-container">
        <div class="navigation-left">
            <ul>
                <li><a href="index.php">Over Ons</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="reserveer.php">Reserveer</a></li>
            </ul>
        </div>
        <div class="navigation-right">
            <?php if (isset($_SESSION['user']['username'])) { ?>
                <a href="private.php" id="login-button">[<?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>]</a>
            <?php } else { ?>
                <a href="login.php?location=<?=urlencode($_SERVER['REQUEST_URI'])?>" id="login-button">Login</a>
            <?php } ?>
        </div>
    </div>
</nav>
</body>
</html>