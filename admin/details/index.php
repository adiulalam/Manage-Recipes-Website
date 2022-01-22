<?php

    
include '../includes/db.inc.php';

try{
    $result= $pdo->query('SELECT *, Author.Name FROM Recipe INNER JOIN Author ON Recipe.AuthorID = Author.Author_ID'); //selects everything from database
}

catch (PDOException $e)
{
    $error = 'Error fetching recipe from the database';
    include 'error.html.php';
    exit();
}


foreach ($result as $row) //makes everything a variable
   {
       $recipes[]=array('ID' => $row['ID'], 'text'=>$row['RecipeText'], 'RecipeDate'=>$row['RecipeDate'], 'Ingredients'=>$row['Ingredients'], 'PrepMethod'=>$row['PrepMethod'], 'PrepTime'=>$row['PrepTime'], 'CookTime'=>$row['CookTime'],'Serving'=>$row['Serving'],'Ref'=>$row['Ref'], 'Name'=>$row['Name']);
    
   }

include 'details.html.php';
?>