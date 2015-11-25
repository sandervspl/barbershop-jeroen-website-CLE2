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
<form method="post" action="">
    <input type="submit" name="prevday" value="< Vorige Dag">
    <input type="submit" name="nextday" value="Volgende Dag >">
</form>

<?php

if (isset($_GET['dag'])) {
    $dag = $_GET['dag'];
} else {
    $dag = 19;
}
if (isset($_GET['maand'])) {
    $maand = $_GET['maand'];
} else {
    $maand = 11;
}
if (isset($_GET['jaar'])) {
    $jaar = $_GET['jaar'];
} else {
    $jaar = 2015;
}

if (isset($_POST['nextday'])) {
    $dag = $dag + 1;

    if ($dag > 31) {
        $dag = 1;
        $maand = $maand + 1;

        if ($maand > 12) {
            $maand = 1;
            $jaar = $jaar + 1;
        }
    }

    if ($dag < 10) {
        $dag = "0".$dag;
    }

    if ($maand < 10) {
        $str = substr($maand, 0, 1);
        if ($str !== '0') {
            $maand = "0".$maand;
        }
    }

    header("Location: ?dag=$dag&maand=$maand&jaar=$jaar");
}
if (isset($_POST['prevday'])) {
    $dag = $dag - 1;

    if ($dag < 1) {
        $dag = 31;
        $maand = $maand - 1;

        if ($maand < 1) {
            $maand = 12;
            $jaar = $jaar - 1;
        }
    }

    if ($dag < 10) {
        $dag = "0".$dag;
    }

    if ($maand < 10) {
        $str = substr($maand, 0, 1);
        if ($str !== '0') {
            $maand = "0".$maand;
        }
    }

    header("Location: ?dag=$dag&maand=$maand&jaar=$jaar");
}

    $uur = 9;
    $m = '';
    $u = '';

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

        $datum = $jaar.'-'.$maand.'-'.$dag;
        $tijd = $u . ":" . $m;
        $b = "nietbezet";

        $db = mysqli_connect('localhost', 'root', '', 'website');
        $sql = sprintf("SELECT * FROM afspraken WHERE datum='%s' AND tijd='%s'",
            mysqli_real_escape_string($db, $datum),
            mysqli_real_escape_string($db, $tijd));
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
            $b = "bezet";
        }
        mysqli_close($db);

        $datum = $dag.'/'.$maand.'/'.$jaar;

        echo "<tr> <td>$datum</td>";
        echo "<td class='$b'>$tijd</td>";

        $dd = $jaar.$maand.$dag;
        $tt = str_replace(':', '', $tijd);
        if ($b === "nietbezet") {
            echo "<td><a href='toevoegen.php?datum=$dd&tijd=$tt'> Reserveer </a></td> </tr>";
        }
    }
?>

<script src="scripts/Nextday.js"></script>
</body>
</html>