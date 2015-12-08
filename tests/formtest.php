<?php
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="UTF-8">
  
    <title>formtest</title>
    
    <link rel="stylesheet" href="">
</head>
<body>
<form id="mainForm" action="#" method="post">
    <div>
        <p>
            <label class="textlabel" for="firstNameInput">Voornaam</label><br/>
            <input id="firstNameInput" name="FirstName" type="text" autofocus="autofocus" class="textinput"/>
        </p>
        <p>
            <label class="textlabel" for="lastNameInput">Achternaam</label><br/>
            <input id="lastNameInput" name="LastName" type="text" class="textinput" size="10"/>
        </p>
        <p>
            <label class="textlabel" for="emailInput">Email</label>
            <input id="emailInput" name="Email" type="email" class="textinput"/>
        </p>

        <p>
            <label class="textlabel" for="streetInput">Telefoonnummer</label>
            <input id="phoneInput" name="PhoneNumber" type="text" class="textinput"/>
        </p>
    </div>

    <input type="submit" class="submitbutton" value="Place order"/>
</form>
</body>
</html>