<?php
require("common.php");

if(isset($_SESSION['user'])) {
    header("Location: private.php");
    die("Redirecting to private.php");
}

$submitted_username = '';
$failed = false;

// This if statement checks to determine whether the login form has been submitted
if(!empty($_POST))
{
    // This query retrieves the user's information from the database using their username.
    $query = "
            SELECT
                id,
                username,
                password,
                salt,
                email
            FROM
                users
            WHERE
                username = :username
        ";

    // The parameter values
    $query_params = array(
        ':username' => $_POST['username']
    );

    try {
        // Execute the query against the database
        $stmt = $db->prepare($query);
        $result = $stmt->execute($query_params);

    } catch(PDOException $ex) {
        header("Location: login.php");
        die("Failed to run query");
    }

    // This variable tells us whether the user has successfully logged in or not.
    $login_ok = false;

    // Retrieve the user data from the database.  If $row is false, then the username they entered is not registered.
    $row = $stmt->fetch();
    if($row) {
        // Using the password submitted by the user and the salt stored in the database,
        // we now check to see whether the passwords match by hashing the submitted password
        // and comparing it to the hashed version already stored in the database.
        $check_password = hash('sha256', $_POST['password'] . $row['salt']);
        for($round = 0; $round < 65536; $round++) {
            $check_password = hash('sha256', $check_password . $row['salt']);
        }

        // If they do, then we flip this to true
        if($check_password === $row['password']) {
            $login_ok = true;
        }
    }

    // If the user logged in successfully, then we send them to the private members-only page
    // Otherwise, we display a login failed message and show the login form again
    if($login_ok)
    {
        // remove sensitive data before storing them into a session array
        unset($row['salt']);
        unset($row['password']);

        // This stores the user's data into the session at the index 'user'.
        $_SESSION['user'] = $row;

        // check if there is a redirect address available and lead the user back to that page
        // if not, then redirect to private page
        $redirect = NULL;
        if($_POST['location'] != '') {
            $redirect = $_POST['location'];
        }

        // if is a redirect address, send the user directly there
        if($redirect) {
            header("Location:". $redirect);
            die("Redirecting to $redirect");
        } else {
            header("Location: private.php");
            die("Redirecting to private.php");
        }
    }
    else
    {
        // Tell the user the login failed
        $failed = true;

        // Show them their username again so all they have to do is enter a new
        // password.  The use of htmlentities prevents XSS attacks.
        $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
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
    <p id="header-text-header">Login</p>
    <div id="basic-wrapper">
        <div class="white-background">
            <div class="login-register-wrapper">
                <form action="login.php" method="post">
                    <label for="username" class="input-text-small">Gebruikersnaam</label><br />
                    <input type="text" id="username" class="textinput" name="username" value="" />
                    <br /><br />
                    <label for="password" class="input-text-small">Wachtwoord</label><br />
                    <input type="password" id="password" class="textinput" name="password" value="" />
                    <?php if ($failed) { ?>
                        <span id="loginFailedError" class="small-text error-text" style="display: block;">Gebruikersnaam en/of wachtwoord is verkeerd</span>
                    <?php } ?>
                    <br /><br />
                    <input type="submit" value="Login" class="button" />
                    <input type="hidden" name="location" value="<?php
                            if(isset($_GET['location'])) {
                                echo htmlspecialchars($_GET['location']);
                            }
                            ?>"/>
                </form>
                <br />
                <div class="registerbutton">
                    <a id="register-button" href="register.php">Registreer</a>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer-sticky">
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>