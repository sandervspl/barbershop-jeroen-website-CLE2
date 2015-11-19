<?php
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Selection Page</title>
    
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<?php

if (isset($_POST['submit'])) {

} else {

    $uur = 9;
    $m = '';
    $u = '';
    $dag = 19;
    $maand = 11;
    $jaar = 2015;
    $bezet = "nee";

    echo "<table>";
    echo "<tr> <th>Datum</th>";
    echo "<th>Tijd</th>";
    echo "<!-- <th>Bezet</th> --> </tr>";


    for ($minuut = 0; $minuut <= 18; $minuut++) {
        if ($minuut % 2 == 0) {
            if ($minuut > 0) $uur++;

            $m = "00";
        }

        if ($minuut % 2) {
            $m = "30";
        }

        if ($uur < 10) {
            $u = "0".$uur;
        } else {
            $u = $uur;
        }

        $tijd = $u . ":" . $m;
        $b = "nietbezet";

        $datum = $dag.'/'.$maand.'/'.$jaar;

        echo "<tr> <td>$datum</td>";
        echo "<td class='$b'>$tijd</td>";

        $dd = $jaar.$maand.$dag;
        $tt = str_replace(':', '', $tijd);
        echo "<td><a href='toevoegen.php?datum=$dd&tijd=$tt'>Reserveer </a></td> </tr>";
    }
}
?>
</body>
</html>