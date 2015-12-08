<?php
$voornaam = '';
$achternaam = '';
$comments = '';
$gender = '';
$tc = '';
$color = '';
$languages = array();

if (isset($_POST['submit'])) {
    $ok = true;
    if (!isset($_POST['name']) || $_POST ['name'] === '') {
        $ok = false;
    } else {
        $voornaam = $_POST['name'];
    }
    if (!isset($_POST['password']) || $_POST ['password'] === '') {
        $ok = false;
    } else {
        $achternaam = $_POST['password'];
    }
    if (!isset($_POST['comments']) || $_POST ['comments'] === '') {
        $ok = false;
    } else {
        $comments = $_POST['comments'];
    }
    if (!isset($_POST['gender']) || $_POST ['gender'] === '') {
        $ok = false;
    } else {
        $gender = $_POST['gender'];
    }
    if (!isset($_POST['tc']) || $_POST ['tc'] === '') {
        $ok = false;
    } else {
        $tc = $_POST['tc'];
    }
    if (!isset($_POST['color']) || $_POST ['color'] === '') {
        $ok = false;
    } else {
        $color = $_POST['color'];
    }
    if (!isset($_POST['languages']) || !is_array($_POST['languages']) || count($_POST['languages']) === 0) {
        $ok = false;
    } else {
        $languages = $_POST['languages'];
    }


    if ($ok) {
        printf('User name: %s
            <br>Password: %s
            <br>Gender: %s
            <br>Color: %s
            <br>Language(s): %s
            <br>Comments: %s
            <br>T&amp;C: %s',
            htmlspecialchars($voornaam),
            htmlspecialchars($achternaam),
            htmlspecialchars($gender),
            htmlspecialchars($color),
            htmlspecialchars(implode(', ', $languages)),
            htmlspecialchars($comments),
            htmlspecialchars($tc)
        );
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
    <title></title>
    
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    
</body>
</html>