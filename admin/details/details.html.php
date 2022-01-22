<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">
	<head>
		<meta charset="utf-8">
		<title>All Recipes Details</title>
		</head>
	<body>
        <h1>All Recipes Details</h1>
        <?php if (isset($recipes)): ?>
        <table border="1px">
            <tr><th>Recipe Text</th><th>Recipe Date</th><th>Author</th><th>Ingredients</th><th>Preparation Method</th><th>Preparation Time (Minutes)</th><th>Cooking Time (Minutes)</th><th>Serving (Per Person)</th><th>Reference (URL)</th></tr>
            <?php foreach ($recipes as $Recipe): ?>
            <tr>
                <td><center><?php echo($Recipe['text']);?></center></td>
                <td><center><?php html($Recipe['RecipeDate']);?></center></td>
                <td><center><?php html($Recipe['Name']);?></center></td>
            <td><textarea cols="60"  rows="10"> <?php html($Recipe['Ingredients']);?></textarea></td>
            <td><textarea cols="60"  rows="10"> <?php html($Recipe['PrepMethod']);?></textarea></td>
                <td><center><?php html($Recipe['PrepTime']);?></center></td>
                <td><center><?php html($Recipe['CookTime']);?></center></td>
                <td><center><?php html($Recipe['Serving']);?></center></td>
                <td><center><?php html($Recipe['Ref']);?></center></td>
            </tr>
            <?php endforeach;?>
                
        </table>
        <?php endif; ?>
        <p><a href="?">New Search</a></p>
        <p><a href="..">Return to CMS home</a></p>
	</body>
	</html>