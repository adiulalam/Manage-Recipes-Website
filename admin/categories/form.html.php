<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">
<head>
    <meta charset="UTF-8">
    <title><?php html($pageTitle);?></title>
</head>
<body>
<h1><?php html($pageTitle);?></h1>
<form action="?<?php html($action); ?>" method="post">
<label for="Name"> Name:<input type="text" name="Name" id="Name" value="<?php html($Name); ?>"></label><br/>
<input type="hidden" name="ID" value="<?php html($ID); ?>">
<input type="submit" value="<?php html($button); ?>">
</form>
</body>
</html>