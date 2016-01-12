<?php
if(!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE HTML>
<html lang="en">
<body>
<!--<div id="main-header">-->
<!--    <a href="index.php"><img src="images/other/bblogo.png" id="header-logo"></a>-->
<!--</div>-->
<nav id="navigation-background">
    <div class="navigation-container">
        <div class="navigation-left">
            <a href="index.php">
                <img src="images/other/bblogo.png">
            </a>
        </div>
        <div class="navigation-center">
            <ul class="navigation-list">
                <li><a href="index.php">Over Ons</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="reserveer.php">Reserveer</a></li>
            </ul>
        </div>
        <div class="navigation-right">
            <?php if (isset($_SESSION['user']['username'])) { ?>
                <a href="private.php" id="nav-login-button">[<?= htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>]</a>
            <?php } else { ?>
                <a href="login.php?location=<?=urlencode($_SERVER['REQUEST_URI'])?>" id="nav-login-button">Login</a>
            <?php } ?>
        </div>
    </div>
</nav>
</body>
</html>