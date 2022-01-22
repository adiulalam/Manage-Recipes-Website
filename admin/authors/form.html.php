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
<label for="Email"> Email:<input type="text" name="Email" id="Email" value="<?php html($Email); ?>"></label><br/>
<label for="Password"> Set Password: <input type="Password" name="Password" id="Password" ></label><br />
<fieldset>
   <fieldset>
        <legend>Roles:</legend>
        <?php for ($i = 0; $i < count($Roles); $i++): ?>
          <div>
            <label for="Role<?php echo $i; ?>"><input type="checkbox"
              name="Roles[]" id="Role<?php echo $i; ?>"
              value="<?php html($Roles[$i]['ID']); ?>"<?php
              if ($Roles[$i]['selected'])
              {
                echo ' checked';
              }
              ?>><?php html($Roles[$i]['ID']); ?></label>:
              <?php html($Roles[$i]['Description']); ?>
          </div>
        <?php endfor; ?>
      </fieldset>

<input type="hidden" name="ID" value="<?php html($ID); ?>">
<input type="submit" value="<?php html($button); ?>">
    </fieldset>
</form>
</body>
</html>