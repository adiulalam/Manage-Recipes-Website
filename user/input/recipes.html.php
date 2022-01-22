<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>List of Recipes</title>
</head>
<body>
    <!--<p><a href="?addrecipe">Add your own recipe</a></p>-->
    <p>Here are all the recipes in the databas</p>
    <table border="1">
    <?php foreach ($recipes as $Recipe): ?>
        <form action="?deleterecipe" method="post">
        <tr>
        <td><?php html($Recipe['RecipeText']);?></td>
        <td><?php $display_date = date("D d M Y", strtotime($Recipe['RecipeDate']));
        html($display_date); ?>
        </td>
        <td><input type="hidden" name="ID" value="<?php echo $Recipe['ID']; ?>">
        <input type="submit" value="Delete"></td>
        <td>(by <a href="mailto:<?php html($Recipe['Email']); ?>">
            <?php html($Recipe['Name']); ?></a>)</td>
        </tr>
        </form>
    <?php endforeach; ?>
    </table>
    <?php include '../includes/footer.inc.html.php'; ?>
</body>
</html>