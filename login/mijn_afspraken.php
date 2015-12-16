<?php
if(!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['remove'])) {
    require_once "../connect.php";
    $db = mysqli_connect($host, $user, $pw, $database);

    $id = $_POST['id'];
    $sql = sprintf("DELETE FROM afspraken WHERE id='%s'",
        mysqli_real_escape_string($db, $id));

    $result = mysqli_query($db, $sql);
}
?>
<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classic Barbershop Jeroen</title>
    <link rel="stylesheet" href="../style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
</head>
<body>

<header>
    <div id="main-header">
        <a href="../index.php"><img src="../images/other/bblogo.png" id="header-logo"></a>
    </div>
    <nav id="navigation-background">
        <div class="navigation-helper">
            <ul>
                <li><a href="../contact.php">Contact</a></li>
                <li><a href="../index.php">Over Ons</a></li>
                <li><a href="../reserveer.php">Reserveer</a></li>
                <li>
                    <?php if (isset($_SESSION['user']['username'])) { ?>
                        <a href="private.php" id="login-button">[<?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?>]</a>
                    <?php } else { ?>
                        <a href="login.php" id="login-button">Login</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </nav>
</header>

<section id="main-page">
    <p id="header-text-header">Mijn afspraken</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <div id="login-register-wrapper">
                <span class="header-text-lobster"><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                <br /><br /><br />
                <div id="account-image">
                    <img src="../images/login/account.png">
                </div>

                <div id="account-text">
                    <?php
                    require_once "../connect.php";
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
                    $appointments = [];

                    while($row = mysqli_fetch_assoc($result)) {
                        $appointments[] = $row;
                    }

                    foreach ($appointments as $appointment) {
                        $id = $appointment['id'];
                        ?>
                        <div class="header-text-small appointment-title">Datum: </div>
                        <div class="header-text-small appointment-value"><?= $appointment['datum'] ?></div>
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

<!--                        TODO: MAKE THIS WORK-->
                        <button id="<?=$id?>" type='submit' name='remove' class="button-delete" value="<?=$id?>")>Verwijder</button>
                        <br/><br />
                        <div class="divider-light"></div>
                        <?php
                    }
                    ?>
                </div>
                <br /><br />
            </div>
        </div>
    </div>
</section>

<footer>
</footer>
</body>
</html>