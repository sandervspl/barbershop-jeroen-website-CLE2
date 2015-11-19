<!DOCTYPE html>
<html>
<head>
    <title>Afspraak Toevoegen</title>

    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php
$voornaam = '';
$achternaam = '';
$datum = 'YYYY/MM/DD';
$tijd = '';
$baard = '';
$kapper = '';

if (isset($_GET["datum"])) {
    $newstr = substr_replace($_GET["datum"], "/", 4, 0);
    $newstr = substr_replace($newstr, "/", 7, 0);
    $datum = $newstr;
}

if (isset($_GET["tijd"])) {
    $newstr = substr_replace($_GET["tijd"], ":", 2, 0);
    $tijd = $newstr;
}

if (isset($_POST['submit'])) {
    $ok = true;
    $error_msg = 'ERROR: Er is een veld verkeerd ingevuld.';

    $db = mysqli_connect('localhost', 'root', '', 'website');
    $sql = sprintf("SELECT * FROM afspraken WHERE (voornaam='%s' AND achternaam='%s')",
        mysqli_real_escape_string($db, $_POST['voornaam']),
        mysqli_real_escape_string($db, $_POST['achternaam']));

    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        $ok = false;
        $error_msg = 'ERROR: Deze persoon zit al in de database.';
    }

    $sql = sprintf("SELECT * FROM afspraken WHERE (datum='%s' AND tijd='%s')",
        mysqli_real_escape_string($db, $_POST['datum']),
        mysqli_real_escape_string($db, $_POST['tijd']));

    $result = mysqli_query($db, $sql);
    if (mysqli_num_rows($result) > 0) {
        $ok = false;
        $error_msg = 'ERROR: Deze dag/tijd is al bezet.';
    }

    mysqli_close($db);

    if (!isset($_POST['voornaam']) || $_POST['voornaam'] === '') {
        $ok = false;
    } else {
        $voornaam = $_POST['voornaam'];
    }
    if (!isset($_POST['achternaam']) || $_POST['achternaam'] === '') {
        $ok = false;
    } else {
        $achternaam = $_POST['achternaam'];
    }

    // i.e. 2015-10-09 or 20151009
    $pattern = '/20([1-9][5-9]|[2-9][0-9])[-\/][0-1][0-9][-\/][0-3][0-9]|20([1-9][5-9]|[2-9][0-9])[0-1][0-9][0-3][0-9]/';
    $match = 0;
    preg_match($pattern, $_POST['datum'], $match);

    if (!isset($_POST['datum']) || $_POST['datum'] === '' || $_POST['datum'] === 'YYYY/MM/DD' || empty($match)) {
        $ok = false;
    } else {
        $datum = $_POST['datum'];
    }
    if (!isset($_POST['tijd']) || $_POST['tijd'] === '') {
        $ok = false;
    } else {
        $tijd = $_POST['tijd'];
    }
    if (!isset($_POST['baard']) || $_POST['baard'] === '') {
        $ok = false;
    } else {
        $baard = $_POST['baard'];
    }
    if (!isset($_POST['kapper']) || $_POST['kapper'] === '') {
        $ok = false;
    } else {
        $kapper = $_POST['kapper'];
    }

    if ($ok) {
        $db = mysqli_connect('localhost', 'root', '', 'website');
        $sql = sprintf("INSERT INTO afspraken (voornaam, achternaam, datum, tijd, baard, kapper) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
            mysqli_real_escape_string($db, $voornaam),
            mysqli_real_escape_string($db, $achternaam),
            mysqli_real_escape_string($db, $datum),
            mysqli_real_escape_string($db, $tijd),
            mysqli_real_escape_string($db, $baard),
            mysqli_real_escape_string($db, $kapper)
        );
        mysqli_query($db, $sql);
        mysqli_close($db);
        echo '<p>Succes! Afspraak toegevoegd.</p>';
    } else {
        echo "<p>$error_msg</p>";
    }
}
?>

    <form method="post" action="">
        <label>voornaam:</label>
        <input type="text" name="voornaam" value="<?php
            echo htmlspecialchars($voornaam);
        ?>" autofocus="autofocus"><br>

        <label>achternaam:</label>
        <input type="text" name="achternaam" value="<?php
        echo htmlspecialchars($achternaam);
        ?>"><br>

        <label>Datum:</label>
        <input type="date" class="disabled" name="datum" value="<?php
        echo htmlspecialchars($datum);
        ?>" disabled><br>

        <label>Tijd:</label>
        <input type="time" class="disabled" name="tijd" value="<?php
        echo htmlspecialchars($tijd);
        ?>" disabled><br>

        <label>Baard doen?</label>
        <select name="baard">
            <option value="">Kies</option>
            <option value="nee" <?php
            if ($baard === 'nee') {
                echo ' selected';
            }
            ?>>nee</option>
            <option value="ja" <?php
            if ($baard === 'ja') {
                echo ' selected';
            }
            ?>>ja</option>
        </select><br>

        <label>Bij wie?</label>
        <select name="kapper">
            <option value="">Kies kapper</option>
            <option value="Jeroen" <?php
            if ($kapper === 'Jeroen') {
                echo ' selected';
            }
            ?>>Jeroen</option>
            <option value="Juno" <?php
            if ($kapper === 'Juno') {
                echo ' selected';
            }
            ?>>Juno</option>
        </select><br><br>

        <label><input type="submit" name="submit" value="submit"></label>
    </form>
</body>
</html>