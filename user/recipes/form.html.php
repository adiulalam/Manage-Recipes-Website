<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
 <script src="https://cdn.tiny.cloud/1/1wx7gr5p6bkko04v21u41sok26ykh1uqu4tkqyhmqiix8lwi/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <title><?php html($pageTitle); ?></title>
</head>
<body>
<h1><?php html($pageTitle); ?></h1>
<form action="?<?php html($action);?>" method="post">
<div><br/>
    <br/>
    <label for="text">Type your recipe here:</label><br/><br/>
    <textarea id="text" name="text" rows="3" cols="40"><?php html($text); ?></textarea><br/>
    </div>
    <div>
        <label for="Author">Author:</label>
        <select name="Author" id="Author">
        <option value="">Select one</option>
        <?php foreach ($authors as $Author):?>
        <option value="<?php html($Author['ID']); ?>"<?php 
            if ($Author['ID'] == $AuthorID)
            {
                echo ' selected';
            }
            ?>><?php html($Author['Name']); ?></option>
        <?php endforeach; ?>
    </select>
</div>
    <fieldset>
        <legend>Categories:</legend>
        <?php foreach ($categories as $Category): ?>
        <div><label for ="Category<?php html($Category['ID']); ?>">
            <input type="checkbox" name="categories[]"
                   value="<?php html($Category['ID']); ?>"<?php
                   if ($Category['selected'])
                   {
                       echo ' checked';
                   }
                   ?>><?php html($Category['Name']); ?></label></div>
        <?php endforeach; ?>
    </fieldset>
<div>
    <input type="hidden" name="ID" value="<?php html($ID); ?>">
    <input type="submit" value="<?php html($button); ?>">
</div>
</form>
      <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
    });
  </script>
</body>
</html>