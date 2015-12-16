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
        ':user_id' => $_SESSION['user']['id'],
    );

    // If the user is changing their password, then we need parameter values
    // for the new password hash and salt too.
    if($password !== null)
    {
        $query_params[':password'] = $password;
        $query_params[':salt'] = $salt;
    }

    // Note how this is only first half of the necessary update query.  We will dynamically
    // construct the rest of it depending on whether or not the user is changing
    // their password.
    $query = "
            UPDATE users
            SET
                email = :email
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
        // Note: On a production website, you should not output $ex->getMessage().
        // It may provide an attacker with helpful information about your code.
        die("Failed to run query: " . $ex->getMessage());
    }

    // Now that the user's E-Mail address has changed, the data stored in the $_SESSION
    // array is stale; we need to update it so that it is accurate.
    $_SESSION['user']['email'] = $_POST['email'];

    // This redirects the user back to the members-only page after they register
    header("Location: private.php");

    // Calling die or exit after performing a redirect using the header function
    // is critical.  The rest of your PHP script will continue to execute and
    // will be sent to the user if you do not die or exit.
    die("Redirecting to private.php");
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
    <p id="header-text-header">Wijzig account</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <div id="login-register-wrapper">
                <form action="edit_account.php" method="post">
                    <span class="header-text-lobster"><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <br /><br /><br />
                    <div id="account-image">
                        <img src="../images/login/account.png">
                    </div>

                    <div id="account-text">
                        <label for="email" class="input-text">E-Mail</label><br />
                        <input id="email" type="text" name="email" value="<?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>" />
                        <br /><br />
                        <label for="password" class="input-text">Wachtwoord</label><br />
                        <input id="password" type="password" name="password" value="" /><br />
                        <p>(laat leeg als je het wachtwoord niet wilt wijzigen)</p>
                        <br /><br />
                        <input type="submit" value="Wijzig Account" class="button" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<footer>
</footer>
</body>
</html>