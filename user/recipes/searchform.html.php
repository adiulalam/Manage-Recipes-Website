<?php include_once '../includes/helpers.inc.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>All Recipes</title>
</head>
<body>
<h1>All Recipes</h1>

<form action="" method="get">
<p>Advanced Search</p>
<div>
    <label for="Author">By Author:</label>
    <select Name="Author" ID="Author">
        <option value="">Any Author</option>
        <?php foreach ($authors as $Author):?>
        <option value="<?php html($Author['ID']); ?>"><?php html($Author['Name']);?></option>
        <?php endforeach; ?>
    </select>
</div>
    
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
                    <input type="button" value="Details" onClick="document.location.href='../details/'" >
            </form>   
            </td>  
            </tr>
            <?php endforeach;?>
        </table>
        <?php endif; ?>   
    
<p><a href="..">Return to CMS home</a></p>
    
</body>
</html>