<?php

// First we execute our common code to connection to the database and start the session
require("common.php");

// At the top of the page we check to see whether the user is logged in or not
if(empty($_SESSION['user']))
{
    // If they are not, we redirect them to the login page.
    header("Location: login.php");

    // Remember that this die statement is absolutely critical.  Without it,
    // people can view your members-only content without logging in.
    die("Redirecting to login.php");
}

// This if statement checks to determine whether the edit form has been submitted
// If it has, then the account updating code is run, otherwise the form is displayed
if(!empty($_POST))
{
    // Make sure the user entered a valid E-Mail address
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        die("Invalid E-Mail Address");
    }

    // If the user is changing their E-Mail address, we need to make sure that
    // the new value does not conflict with a value that is already in the system.
    // If the user is not changing their E-Mail address this check is not needed.
    if($_POST['email'] != $_SESSION['user']['email'])
    {
        // Define our SQL query
        $query = "
                SELECT
                    1
                FROM users
                WHERE
                    email = :email
            ";

        // Define our query parameter values
        $query_params = array(
            ':email' => $_POST['email']
        );

        try
        {
            // Execute the query
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        }
        catch(PDOException $ex)
        {
            // Note: On a production website, you should not output $ex->getMessage().
            // It may provide an attacker with helpful information about your code.
            die("Failed to run query: " . $ex->getMessage());
        }

        // Retrieve results (if any)
        $row = $stmt->fetch();
        if($row)
        {
            die("This E-Mail address is already in use");
        }
    }

    // If the user entered a new password, we need to hash it and generate a fresh salt
    // for good measure.
    if(!empty($_POST['password']))
    {
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['password'] . $salt);
        for($round = 0; $round < 65536; $round++)
        {
            $password = hash('sha256', $password . $salt);
        }
    }
    else
    {
        // If the user did not enter a new password we will not update their old one.
        $password = null;
        $salt = null;
    }

    // Initial query parameter values
    $query_params = array(
        ':email' => $_POST['email'],
        ':telefoon' => $_POST['telefoon'],
        ':user_id' => $_SESSION['user']['id'],
    );

    // If the user is changing their password, then we need parameter values
    // for the new password hash and salt too.
    if($password !== null)
    {
        $query_params[':password'] = $password;
        $query_params[':salt'] = $salt;
    }


    $query = "
            UPDATE users
            SET
                email = :email
                , telefoon = :telefoon
        ";

    // If the user is changing their password, then we extend the SQL query
    // to include the password and salt columns and parameter tokens too.
    if($password !== null)
    {
        $query .= "
                , password = :password
                , salt = :salt
            ";
    }

    // Finally we finish the update query by specifying that we only wish
    // to update the one record with for the current user.
    $query .= "
            WHERE
                id = :user_id
        ";

    try
    {
        // Execute the query
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query 1: " . $ex->getMessage());
    }

    // Now that the user's E-Mail address has changed, the data stored in the $_SESSION
    // array is stale; we need to update it so that it is accurate.
    $_SESSION['user']['email'] = $_POST['email'];



    // Redirect
    $redirect = NULL;
    if($_POST['location'] != '') {
        $redirect = $_POST['location'];
    }

    // if is a redirect address, send the user directly there
    if($redirect) {
        header("Location:". $redirect);
    } else {
        header("Location: edit_account_success.php");
        die("Redirecting to edit_account_success.php");
    }

    exit();
}


// database connection information
require_once "connect.php";

$db =  mysqli_connect($host, $user, $pw, $database) or die('Error: '.mysqli_connect_error());

$sql = sprintf("SELECT voornaam, achternaam, telefoon FROM users WHERE username='%s'",
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
$telefoon   = $gegevens['telefoon'];
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
    <div id="basic-wrapper">
        <p id="header-text-header">Wijzig Account</p>

        <div class="ta-left">
            <a href="private.php">< opties</a>
        </div>

        <div class="white-background">
            <div id="account-wrapper-wide">
                <form id="edit-account-form" action="edit_account.php" method="post">
                    <div id="account-image">
                        <img src="images/login/account.png">
                    </div>

                    <div id="account-text">
                        <span class="header-text-lobster"><?= htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <br />
                        <span class="capitalize"><?= $voornaam . " " . $achternaam ?></span>
                        <br /><br />
                        <label for="email" class="input-text">E-Mail</label><br />
                        <input id="email" type="email" name="email" value="<?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>" />
                        <br /><br />

                        <label for="telefoon" class="input-text">Telefoon</label><br />
                        <input id="telefoon" type="text" name="telefoon" value="<?= $telefoon ?>" />
                        <br /><br />

                        <label for="password" class="input-text">Wachtwoord</label><br />
                        <input id="password" type="password" name="password" value="" /><br />
                        <p class="small-text">(laat leeg als je het wachtwoord niet wilt wijzigen)</p>
                        <br />

                        <input type="submit" value="Bevestig" class="button" />
                        <input type="hidden" name="location" value="<?php
                        if(isset($_GET['location'])) {
                            echo htmlspecialchars($_GET['location']);
                        }
                        ?>"/>
                    </div>
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