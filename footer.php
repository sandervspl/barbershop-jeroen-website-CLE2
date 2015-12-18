<?php
if(!isset($_SESSION)) {
    session_start();
}

$year = date("y");

?>
<!DOCTYPE HTML>
<html lang="en">
<body>
<div class="footer-container">
    <div class="left">© ‘<?=$year?> / <a href="credits.php">Credits</a> / <a href="admin.php">Admin</a></div>
    <div class="right"><a href="#">Made by Sander Vispoel</a></div>
</div>
</body>
</html>