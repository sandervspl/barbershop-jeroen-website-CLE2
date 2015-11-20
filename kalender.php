<?php
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kalender</title>

    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<table>
    <tr class="kalenderdag">
        <th>Maandag</th>
        <th>Dinsdag</th>
        <th>Woensdag</th>
        <th>Donderdag</th>
        <th>Vrijdag</th>
        <th>Zaterdag</th>
        <th>Zondag</th>
    </tr>
    <tr>
        <?php
        $i = 1;
        for ($i; $i <= 7; $i++) {
            echo "<td class='kalenderdatum'><label>$i</label></td>";
        }
        ?>
    </tr>
    <tr>
        <?php
        for ($i; $i <= 14; $i++) {
            echo "<td class='kalenderdatum'><label>$i</label></td>";
        }
        ?>
    </tr>
    <tr>
        <?php
        for ($i ; $i <= 21; $i++) {
            echo "<td class='kalenderdatum'><label>$i</label></td>";
        }
        ?>
    </tr>
    <tr>
        <?php
        for ($i ; $i <= 28; $i++) {
            echo "<td class='kalenderdatum'><label>$i</label></td>";
        }
        ?>
    </tr>
    <tr>
        <?php
        for ($i ; $i <= 31; $i++) {
            echo "<td class='kalenderdatum'><label>$i</label></td>";
        }
        ?>
    </tr>
</table>
</body>
</html>