<?php
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kalender</title>
    
    <link rel="stylesheet" style="style/style.css">
</head>
<body>

<?php
    $db = mysqli_connect('localhost', 'root', '', 'afspraken');
    $sql = sprintf("SELECT * FROM afspraken");
    $result = mysqli_query($db, $sql);

    foreach($result as $row) {
        echo "<table>";
        echo "<tr> <th>Voornaam</th>";
        echo "<th>Achternaam</th>";
        echo "<th>Datum</th>";
        echo "<th>Tijd</th>";
        echo "<th>Baard</th>";
        echo "<th>Bij wie</th> </tr>";

        echo "<tr> <td>$voornaam</td>";
        echo "<td>$achternaam</td>";
        echo "<td>$datum</td>";
        echo "<td>$tijd</td>";
        echo "<td>$baard</td>";
        echo "<td>$kapper</td> </tr>";
    }
?>

</body>
</html>