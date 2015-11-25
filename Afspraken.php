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
        $u = "0".$hour;
    } else {
        $u = $hour;
    }

    $time = $u.":".$m;
    $db = mysqli_connect('localhost', 'root', '', 'website');
    $sql = sprintf("SELECT * FROM afspraken WHERE datum='%s' AND tijd='%s'",
        mysqli_real_escape_string($db, $date),
        mysqli_real_escape_string($db, $time));
    $result = mysqli_query($db, $sql);

    echo "<table class='appointments-table'>";
    echo "<td class='appointments-time' colspan='2'>", $time, "</td></tr>";

    if (mysqli_num_rows($result) > 0) {
        foreach ($result as $row) {
            echo "<tr><th>Naam</th>";
            echo "<td>", $row['voornaam'], " ", $row['achternaam'], "</td><tr>";
            echo "<tr><th>Baard</th>";
            echo "<td>", $row['baard'], "</td></tr>";
            echo "<tr><th>Kapper</th>";
            echo "<td>", $row['kapper'], "</td></tr>";

//            $appointments[] = array(
//                'voornaam' => $row['voornaam'],
//                'achternaam' => $row['achternaam'],
//                'datum' => $row['datum'],
//                'tijd' => $row['tijd'],
//                'baard' => $row['baard'],
//                'kapper' => $row['kapper']
//            );
        }
    }

    echo "</table>";

    mysqli_close($db);
}

//foreach ($appointments as $row) {
//    echo "<table class='appointments-table'>";
////    echo "<tr><th>Tijd</th>";
//    echo "<td class='appointments-time' colspan='2'>", $row['tijd'], "</td></tr>";
//    echo "<tr><th>Naam</th>";
//    echo "<td>", $row['voornaam'], " ", $row['achternaam'], "</td><tr>";
//    echo "<tr><th>Baard</th>";
//    echo "<td>", $row['baard'], "</td></tr>";
//    echo "<tr><th>Kapper</th>";
//    echo "<td>", $row['kapper'], "</td></tr>";
//    echo "</table>";
//}
?>

</body>
</html>