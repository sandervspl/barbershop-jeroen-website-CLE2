<?php
if(!isset($_SESSION)) {
    session_start();
}

?>
<!DOCTYPE HTML>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classics Barbershop Jeroen</title>
    <link rel="stylesheet" href="style/style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<!--    GOOGLE MAPS API-->
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
        function initMap() {
            var myLatLng = {lat: 51.819129, lng: 4.643368};

            var map = new google.maps.Map(document.getElementById('map'), {
                scrollwheel: false,
                navigationControl: true,
                mapTypeControl: false,
                scaleControl: false,
                draggable: true,
                zoom: 16,
                center: myLatLng
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Classics Barbershop Jeroen'
            });
        }
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
</head>
<body>

<header>
    <?php require_once "header.php" ?>
</header>

<section id="main-page">
    <p id="header-text-header">Contact</p>
    <div id="contactpage-text-wrapper">
        <div class="white-background">
        <div id="contact-wrapper">
            <div id="contact-img-wrapper">
                <img class="contact-img" src="images/contact/location.png">
            </div>
            <div id="contact-text-wrapper">
                <p><strong>Classics Barbershop Jeroen</strong></p><br />
                <p>Passage 8</p><br />
                <p>3331CM Zwijndrecht</p><br/>
            </div>
        </div>
        <div id="phone-wrapper">
            <div id="phone-img-wrapper">
                <img class="contact-img" src="images/contact/phone.png">
            </div>
            <div id="phone-text-wrapper">
                <p>078 - 6452920</p>
            </div>
        </div>
        <div id="facebook-wrapper">
            <div id="facebook-img-wrapper">
                <a href="https://www.facebook.com/pages/Classics-Barbershop-Jeroen/192319830891775"><img class="contact-img" src="images/contact/facebook.png"></a>
            </div>
            <div id="facebook-text-wrapper">
                <a href="https://www.facebook.com/pages/Classics-Barbershop-Jeroen/192319830891775"><p>Like ons op Facebook!</p></a>
            </div>
        </div>
        </div>
    </div>
    <div id="contactpage-maps-wrapper">
        <div id="map" class="white-background"></div>
    </div>
</section>

<footer>
    <?php require_once "footer.php" ?>
</footer>
</body>
</html>