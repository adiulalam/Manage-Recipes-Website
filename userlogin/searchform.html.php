<?php include_once '../admin/includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Manage Recipes</title>
</head>
<body>
<h1>Manage Recipes</h1>
<p><a href="?add">Add new recipe</a></p>
<form action="" method="get">
<p>View recipes satisfying the following criteria</p>
    <input type="hidden" name="Author" value="<?php html($_SESSION['aid']); ?>">
<div>
    <label for="Category">By Category:</label>
    <select Name="Category" ID="Category">
        <option value="">Any Category</option>
        <?php foreach ($categories as $Category):?>
        <option value="<?php html($Category['ID']); ?>"><?php html($Category['Name']);?></option>
        <?php endforeach; ?>
    </select>
</div>
    
<div>
    <label for="text">Containing text</label>
    <input type="text" name="text" id="text">
</div>
    
<div>
    <input type="hidden" name="action" value="search">
    <input type="submit" value="search">
</div>
    
</form>
<p><a href="../user/">Return to CMS home</a></p>
<?php include 'logout.inc.html.php';?>

</body>
</html>