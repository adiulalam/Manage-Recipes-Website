<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">
	<head>
		<meta charset="utf-8">
		<title>Manage Recipes: Search Results</title>
		</head>
	<body>
        <h1>Search Results</h1>
        <?php if (isset($recipes)): ?>
        <table>
            <tr><th>Recipe Text</th><th>Image</th><th>Options</th></tr>
            <?php foreach ($recipes as $Recipe): ?>
            <tr>
            <td><?php echo($Recipe['text']);?></td>
            <td><img src="../img/<?php echo htmlspecialchars($Recipe['Image']);?>" style="width:300px;height:200px;"/></td>
            <td>
            <form action="?" method="post">          
                <input type="hidden" name="ID" value="<?php echo $Recipe['ID']; ?>">
                    <input type="submit" name="action" value="Edit">
                    <input type="submit" name="action" value="Delete">
                    <input type="button" value="Details" onClick="document.location.href='../details/'" >
            </form>   
            </td>  
            </tr>
            <?php endforeach;?>
        </table>
        <?php endif; ?>
        <p><a href="?">New Search</a></p>
        <?php include_once '../logout.inc.html.php';?>
        <p><a href="..">Return to CMS home</a></p>
	</body>
	</html>