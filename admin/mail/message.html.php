<!DOCTYPE html>
<html lang= "en">
<head>
    <meta charset="UTF-8">
    <title>sent message</title>
</head>
<body>
<?php
ini_set("SMTP", "smtp.gre.ac.uk");
ini_set("sendmail_from", "aa6932u@gre.ac.uk");
echo "Message: <br />" . $_POST['message'] ."<br /> sent to:<br />";
foreach ($authors as $Author):
    mail($Author['Email'], $_POST['subject'], $_POST['message']);
    echo  $Author['Name'] . "<br />";
endforeach; ?>
<p><a href="..">Return to CMS Home</a></p>
</body>
</html>