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
$db = mysqli_connect('localhost', 'root', '', 'website');
$sql = sprintf("SELECT * FROM afspraken");
$result = mysqli_query($db, $sql);

foreach ($result as $row) {
    $v = $row['voornaam'];
    $a = $row['achternaam'];
    $d = $row['datum'];
    $t = $row['tijd'];
    $b = $row['baard'];
    $j = $row['kapper'];

    echo "<table>";
    echo "<tr> <th>Voornaam</th>";
    echo "<th>Achternaam</th>";
    echo "<th>Datum</th>";
    echo "<th>Tijd</th>";
    echo "<th>Baard</th>";
    echo "<th>Bij wie</th> </tr>";

    echo "<tr> <td>$v</td>";
    echo "<td>$a</td>";
    echo "<td>$d</td>";
    echo "<td>$t</td>";
    echo "<td>$b</td>";
    echo "<td>$j</td> </tr>";
}
?>

</body>
</html>