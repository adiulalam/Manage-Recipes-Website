<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Manage Categories</title>
</head>

<body>
    <h1>Manage Categories</h1>
    <p><a href="?add">Add new category</a></p>
    <table border="1px">
        <?php foreach($categories as $Category): ?>
        <form action="" method="post">
            <tr>
                <td><?php html($Category['Name']); ?> </td>
                <td><img src="../img/<?php echo htmlspecialchars($Category['Image']);?>" style="width:50px;height:50px;"/></td>
                <input type="hidden" name="ID" value="<?php echo $Category['ID']; ?>">
                <td><input type="submit" name="action" value="Edit"></td>
                <td><input type="submit" name="action" value="Delete"></td>
            </tr>
        </form>
        <?php endforeach; ?>
    </table>
    <?php include_once '../logout.inc.html.php';?>
    <p><a href="..">Return to CMS home</a></p>
</body>

</html>