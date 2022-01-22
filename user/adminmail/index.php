<!DOCTYPE html>
<html lang= "en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Form</title>
</head>
<body>
<h1>Send Feedback</h1>
<form action="mail.php" method="POST">
<p>Name <br/> <input type="text" name="name"></p>
<p>Email <br/> <input type="text" name="email"></p>
<p>Message <br/> <textarea name="message" rows="6" cols="25"></textarea><br /></p>
<input type="submit" value="Send"><input type="reset" value="Clear">
</form>