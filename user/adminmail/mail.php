<?php 
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$formcontent="From: $name \n Message: $message";
$recipient = "aa6932u@gre.ac.uk";
$subject = "Contact Form";
$mailheader = "From: $email \r\n";
ini_set("SMTP", "smtp.gre.ac.uk");
ini_set("sendmail_from", "aa6932u@gre.ac.uk");
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
echo "Thank You!";
?>