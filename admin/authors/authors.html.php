<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang= "en">
	<head>
		<meta charset="utf-8">
		<title>Manage Authors</title>
		</head>
	<body>
        <h1>Manage Authors</h1>
        <p><a href="?add">Add new author</a></p>
        <table border="1px">
            <?php foreach ($authors as $Author): ?>
            <form action="" method="post">
            <tr>
                <td> <?php html($Author['Name']);?></td>
                <td> <?php html($Author['Email']);?></td>
                <td><img src="../img/<?php echo htmlspecialchars($Author['Image']);?>" style="width:70px;height:70px;"/></td>
                <input type="hidden" name="ID" value="<?php echo $Author['ID']; ?>">
                <td> <input type="submit" name="action" value="Edit"></td>
                <td> <input type="submit" name="action" value="Delete"></td>
            </tr>
            </form>
            <?php endforeach;?>
        </table>
        <?php include_once '../logout.inc.html.php';?>
        <p><a href="..">Return to CMS home</a></p>
	</body>
	</html>