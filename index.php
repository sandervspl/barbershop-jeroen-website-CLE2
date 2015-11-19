<!DOCTYPE html>
<html>
<head>
    <title>Afspraak Toevoegen</title>
</head>
<body>

<?php
$voornaam = '';
$achternaam = '';
$datum = 'YYYY/MM/DD';
$tijd = '';
$baard = '';
$kapper = '';

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
        $_POST['datum'],
        $_POST['tijd']);

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
    $pattern = '/20([1-9][5-9]|[2-9][0-9])-[0-1][0-9]-[0-3][0-9]|20([1-9][5-9]|[2-9][0-9])[0-1][0-9][0-3][0-9]/';
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
        echo '<p>Afspraak toegevoegd.</p>';
    } else {
        echo $error_msg;
    }
}
?>

    <form method="post" action="">
        voornaam: <input type="text" name="voornaam" value="<?php
            echo htmlspecialchars($voornaam);
        ?>" autofocus="autofocus"><br>

        achternaam: <input type="text" name="achternaam" value="<?php
        echo htmlspecialchars($achternaam);
        ?>"><br>

        Datum: <input type="date" name="datum" value="<?php
        echo htmlspecialchars($datum);
        ?>"><br>

        Tijd: <input type="time" name="tijd" value="<?php
        echo htmlspecialchars($tijd);
        ?>"><br>

        Baard doen?
        <select name="baard">
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

        Bij wie?
        <select name="baard">
            <option value="" <?php
            if ($kapper === '') {
                echo ' selected';
            }
            ?>>Kies kapper</option>
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

        <input type="submit" name="submit" value="submit">
    </form>
</body>
</html>