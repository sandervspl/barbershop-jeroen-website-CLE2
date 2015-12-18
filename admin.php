<?php
if(!isset($_SESSION)) {
    session_start();
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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Admin Login</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <div id="login-register-wrapper">
                <form action="login.php" method="post">
                    <label for="username" class="input-text-small">Gebruikersnaam</label><br />
                    <input type="text" id="username" class="textinput" name="username" value="<?php echo $submitted_username; ?>" />
                    <br /><br />
                    <label for="password" class="input-text-small">Wachtwoord</label><br />
                    <input type="password" id="password" class="textinput" name="password" value="" />
                    <br /><br />
                    <input type="submit" value="Login" class="button" />
                </form>
            </div>
        </div>
    </div>
</section>
<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>