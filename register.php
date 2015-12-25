<?php
require("common.php");

// logged in users shouldn't have access to this page
if(isset($_SESSION['user'])) {
    header("Location: private.php");
    die("Redirecting to private.php");
}

$usernameExists = false;
$emailExists = false;
$emailInvalid = false;
$error = 0;

$username = '';
$voornaam = '';
$achternaam = '';
$telefoon = '';
$email = '';

// check submitted data if there is any
if(!empty($_POST))
{
    if(empty($_POST['username'])) {
        $error++;
    } else {
        $username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
    }

    if(empty($_POST['password'])) {
        $error++;
    }

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error++;
    } else {
        $email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
    }

    if(empty($_POST['voornaam'])) {
        $error++;
    } else {
        $voornaam = htmlentities($_POST['voornaam'], ENT_QUOTES, 'UTF-8');
    }

    if(empty($_POST['achternaam'])) {
        $error++;
    } else {
        $achternaam = htmlentities($_POST['achternaam'], ENT_QUOTES, 'UTF-8');
    }

    if(empty($_POST['telefoon'])) {
        $error++;
    } else {
        $telefoon = htmlentities($_POST['telefoon'], ENT_QUOTES, 'UTF-8');
    }

    // We will use this SQL query to see whether the username entered by the
    // user is already in use.
    // :username is a special token, we will substitute a real value in its place when
    // we execute the query.
    $query = "SELECT 1 FROM users WHERE username = :username";

    // This contains the definitions for any special tokens that we place in
    // our SQL query.  In this case, we are defining a value for the token
    // :username.  It is possible to insert $_POST['username'] directly into
    // your $query string; however doing so is very insecure and opens your
    // code up to SQL injection exploits.  Using tokens prevents this.
    // For more information on SQL injections, see Wikipedia:
    // http://en.wikipedia.org/wiki/SQL_Injection
    $query_params = array(
        ':username' => $_POST['username']
    );

    try {
        // These two statements run the query against your database table.
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);

    } catch(PDOException $ex) {
        die("Failed to run query");
    }

    $row = $stmt->fetch();

    // If a row was returned, then we know a matching username was found in
    // the database already and we should not allow the user to continue.
    if($row) {
        $usernameExists = true;
    }

    // Now we perform the same type of check for the email address, in order
    // to ensure that it is unique.
    $query = "SELECT 1 FROM users WHERE email = :email";

    $query_params = array(
        ':email' => $_POST['email']
    );

    try {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);

    } catch(PDOException $ex) {
        die("Failed to run query");
    }

    // If a row was returned, then we know a matching e-mail was found in
    // the database already and we should not allow the user to continue.
    $row = $stmt->fetch();
    if($row) {
        $emailExists = true;
        $error++;
    }



    if (!$error) {
        $query = "
                INSERT INTO users (
                    username,
                    password,
                    salt,
                    email,
                    voornaam,
                    achternaam,
                    telefoon
                ) VALUES (
                    :username,
                    :password,
                    :salt,
                    :email,
                    :voornaam,
                    :achternaam,
                    :telefoon
                )
            ";

        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['password'] . $salt);

        for($round = 0; $round < 65536; $round++) {
            $password = hash('sha256', $password . $salt);
        }

        $query_params = array(
            ':username' => $_POST['username'],
            ':password' => $password,
            ':salt' => $salt,
            ':email' => $_POST['email'],
            ':voornaam' => $_POST['voornaam'],
            ':achternaam' => $_POST['achternaam'],
            ':telefoon' => $_POST['telefoon']
        );

        try {
            // Execute the query to create the user
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);

        } catch(PDOException $ex) {
            $error++;
        }

        // redirect
        header("Location: registration_complete.php");
        die("Redirecting to registration_complete.php");
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
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Registreer</p>

    <div class="small-wrapper margin-r-5">
        <div class="white-background">
            <div class="register-wrapper register-text">
                <div id="account-image">
                    <img src="images/login/account.png">
                </div>

                <p>Een account aanmaken kent meerdere voordelen.</p>

                <ul>
                    <li>Reserveer makkelijk en snel!</li>
                    <li>Je kunt al jouw afspraken bekijken en wijzigen</li>
                    <li>Krijg als eerste te horen van onze acties</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="small-wrapper margin-l-5">
        <div class="white-background">
            <form action="register.php" method="post" onsubmit="return validateForm()">
                <div class="register-wrapper">
                    <p class="header-text-lobster">Gegevens</p>

                        <label for="username" class="input-text-small">Gebruikersnaam</label>
                        <input id="username" type="text" name="username" value="<?=$username?>" onblur="validateUsername(id)" />
                        <div id="usernameError" class="small-text error-text error-text-wrapper" style="visibility: hidden;">Gebruik alleen letters, - of _</div>
                        <?php if ($usernameExists) { ?>
                            <span id="usernameAlreadyInDBError" class="small-text error-text" style="display: block;">Er is al een gebruiker met deze naam</span>
                            <script src="scripts/validation.js"></script>
                            <script type="text/javascript"> setInputFalse("username"); </script>
                        <?php } ?>

                        <label for="voornaam" class="input-text-small">Voornaam</label>
                        <input id="voornaam" type="text" name="voornaam" value="<?=$voornaam?>" onblur="validateNaam(id)" />
                        <div id="voornaamError" class="small-text error-text error-text-wrapper" style="visibility: hidden;">Gebruik alleen letters, - of '</div>

                        <label for="achternaam" class="input-text-small">Achternaam</label>
                        <input id="achternaam" type="text" name="achternaam" value="<?=$achternaam?>" onblur="validateNaam(id)" />
                        <div id="achternaamError" class="small-text error-text error-text-wrapper" style="visibility: hidden;">Gebruik alleen letters, - of '</div>

                        <label for="email" class="input-text-small">E-Mail</label>
                        <input id="email" type="email" name="email" value="<?=$email?>" onblur="validateEmail(id)" />
                        <div id="emailError" class="small-text error-text error-text-wrapper" style="visibility: hidden;">Voer een geldig e-mail adres in</div>
                        <?php if ($emailExists) { ?>
                            <span id="emailAlreadyInDBError" class="small-text error-text" style="display: block;">Er is al een gebruiker met dit e-mail adres</span>
                            <script src="scripts/validation.js"></script>
                            <script type="text/javascript"> setInputFalse("email"); </script>
                        <?php } ?>

                        <label for="telefoon" class="input-text-small">Telefoon</label>
                        <input id="telefoon" type="text" name="telefoon" value="<?=$telefoon?>" onblur="validateTelefoon(id)" />
                        <div id="telefoonError" class="small-text error-text error-text-wrapper" style="visibility: hidden;">Voer een geldig telefoonnummer in</div>

                        <label for="password" class="input-text-small">Wachtwoord</label>
                        <input id="password" type="password" name="password" value="" onblur="validatePassword(id)" />
                        <div id="passwordError" class="small-text error-text error-text-wrapper" style="visibility: hidden;">Minimaal 5 en maximaal 24 letters, nummers, of speciale karakters</div>
                </div>
                <input type="submit" id="register-button" class="button" value="Registreer" />
            </form>
        </div>
    </div>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>

<script src="scripts/validation.js"></script>
</body>
</html>