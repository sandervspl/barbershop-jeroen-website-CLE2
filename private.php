<?php

// First we execute our common code to connection to the database and start the session
require("common.php");
require_once("User.php");

// At the top of the page we check to see whether the user is logged in or not
if(empty($_SESSION['user']))
{
    // If they are not, we redirect them to the login page.
    header("Location: login.php");
    die("Redirecting to login.php");
}

// Everything below this point in the file is secured by the login system
?>
<?php

if(!empty($_POST))
{
    // Ensure that the user has entered a non-empty username
    if(empty($_POST['username']))
    {
        die("Please enter a username.");
    }

    // Ensure that the user has entered a non-empty password
    if(empty($_POST['password']))
    {
        die("Please enter a password.");
    }

    // Make sure the user entered a valid E-Mail address
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        die("Invalid E-Mail Address");
    }

    // We will use this SQL query to see whether the username entered by the
    // user is already in use.
    $query = "SELECT
                1
              FROM
                users
              WHERE
                username = :username
             ";

    // This contains the definitions for any special tokens that we place in
    // our SQL query.  In this case, we are defining a value for the token :username.
    $query_params = array(
        ':username' => $_POST['username']
    );

    try
    {
        // These two statements run the query against your database table.
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    // The fetch() method returns an array representing the "next" row from
    // the selected results, or false if there are no more rows to fetch.
    $row = $stmt->fetch();

    // If a row was returned, then we know a matching username was found in
    // the database already and we should not allow the user to continue.
    if($row)
    {
        die("This username is already in use");
    }

    // Now we perform the same type of check for the email address, in order
    // to ensure that it is unique.
    $query = "SELECT
                1
              FROM
                users
              WHERE
                email = :email
             ";

    $query_params = array(
        ':email' => $_POST['email']
    );

    try
    {
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    $row = $stmt->fetch();

    if($row)
    {
        die("This email address is already registered");
    }

    // An INSERT query is used to add new rows to a database table.
    // Again, we are using parameters to protect against SQL injection attacks.
    $query = "
            INSERT INTO
            users (
                username,
                password,
                salt,
                email
            ) VALUES (
                :username,
                :password,
                :salt,
                :email
            )
        ";

    // A salt is randomly generated here to protect again brute force attacks
    // and rainbow table attacks.  The following statement generates a hex
    // representation of an 8 byte salt.  Representing this in hex provides
    // no additional security, but makes it easier for humans to read.
    $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));

    // This hashes the password with the salt so that it can be stored securely
    // in your database.  The output of this next statement is a 64 byte hex
    // string representing the 32 byte sha256 hash of the password.  The original
    // password cannot be recovered from the hash.
    $password = hash('sha256', $_POST['password'] . $salt);

    // Next we hash the hash value 65536 more times.  The purpose of this is to
    // protect against brute force attacks.  Now an attacker must compute the hash 65537
    // times for each guess they make against a password, whereas if the password
    // were hashed only once the attacker would have been able to make 65537 different
    // guesses in the same amount of time instead of only one.
    for($round = 0; $round < 65536; $round++)
    {
        $password = hash('sha256', $password . $salt);
    }

    // Here we prepare our tokens for insertion into the SQL query.  We do not
    // store the original password; only the hashed version of it.  We do store
    // the salt (in its plaintext form; this is not a security risk).
    $query_params = array(
        ':username' => $_POST['username'],
        ':password' => $password,
        ':salt' => $salt,
        ':email' => $_POST['email']
    );

    try
    {
        // Execute the query to create the user
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch(PDOException $ex)
    {
        die("Failed to run query: " . $ex->getMessage());
    }

    // This redirects the user back to the login page after they register
    header("Location: login.php");
    die("Redirecting to login.php");
}


$user_ = new User;

// level check
$isAdmin = $user_->getUserLvl();

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
    <p id="header-text-header">Jouw account</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <div id="account-wrapper-wide">
                <span class="header-text-lobster"><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                <br /><br /><br />
                <div id="account-image">
                    <img src="images/login/account.png">
                </div>

                <div id="account-text">
<?php
                    if ($isAdmin) {
?>
                        <a href="admin.php">Admin Pagina</a><br/>
<?php
                    } else {
?>
                        <a href="mijn_afspraken.php">Mijn Afspraken</a><br/>
<?php
                    }
?>
                    <a href="edit_account.php">Wijzig Gegevens</a><br />
                    <br />
                    <a href="logout.php">Uitloggen</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>