<?php
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Afspraken</title>

    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php
if (isset($_GET['month']) && isset($_GET['year']) && isset($_GET['day'])) {
    $day = $_GET['day'];
    $month = $_GET['month'];
    $year = $_GET['year'];
} else {
    $day = date("d");
    $month = date("m");
    $year = date("Y");
}

$date = $year."-".$month."-".$day;
$hour = 9;
$hours = 18;
$appointments = array();

for ($minute = 0; $minute <= 18; $minute++) {
    if ($minute % 2 == 0) {
        if ($minute > 0)
            $hour++;

        $m = "00";
    }

    if ($minute % 2) {
        $m = "30";
    }

    if ($hour < 10) {
        $u = "0" . $hour;
    } else {
        $u = $hour;
    }

    $time = $u . ":" . $m;
    $db = mysqli_connect('localhost', 'root', '', 'website');
    $sql = sprintf("SELECT * FROM afspraken WHERE datum='%s' AND tijd='%s'",
        mysqli_real_escape_string($db, $date),
        mysqli_real_escape_string($db, $time));
    $result = mysqli_query($db, $sql);

    if ($minute % 6 == 0) {
        $b = "appointments-table-clear";
    } else {
        $b = "appointments-table";
    }

    echo "<table class=$b>";
    echo "<td class='appointments-time' colspan='2'> $time </td>";

    if (mysqli_num_rows($result) > 0) {
        foreach ($result as $row) {
            echo "<tr><th class='appointments-key'>Naam</th>";
            echo "<td>", $row['voornaam'], " ", $row['achternaam'], "</td><tr>";
            echo "<tr><th class='appointments-key'>Baard</th>";
            echo "<td>", $row['baard'], "</td></tr>";
            echo "<tr><th class='appointments-key'>Kapper</th>";
            echo "<td>", $row['kapper'], "</td></tr>";
        }
    }

    mysqli_close($db);

    echo "</table>";
}
?>
</body>
</html>