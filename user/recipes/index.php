<?php
 
if(isset($_GET['action']) and $_GET['action']=='search')
{
    include '../includes/db.inc.php';
    
$select = 'SELECT ID, RecipeText, Image';
$from = ' FROM Recipe';
$where = ' WHERE TRUE';
$placeholders = array();
    
if ($_GET['Author'] != '')
{
    $where .=" AND AuthorID = :AuthorID";
    $placeholders[':AuthorID']=$_GET['Author'];
}

if ($_GET['Category'] != '')
{
    $from .= ' INNER JOIN RecipeCategory ON ID= RecipeID';
    $where .= " AND CategoryID = :CategoryID";
    $placeholders[':CategoryID']=$_GET['Category'];
}
    
if ($_GET['text'] != '')
{
    $where .= " AND RecipeText LIKE :RecipeText";
    $placeholders[':RecipeText']= '%' . $_GET['text'] . '%';
}
    
try
{
    $sql = $select . $from . $where;
    $s = $pdo->prepare($sql);
    $s->execute($placeholders);
}
catch (PDOException $e)
{
    $error = 'Error fetching recipes';
    include 'error.html.php';
    exit();
}
foreach ($s as $row)
{
    $recipes[]=array('ID' => $row['ID'], 'text'=>$row['RecipeText'], 'Image'=>$row['Image']);
}

include 'recipes.html.php';
exit();
}

include '../includes/db.inc.php';
try{
    $result= $pdo->query('SELECT Author_ID, Name FROM Author');
}
catch (PDOException $e)
{
    $error = 'Error fetching authors from the database';
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
   {
       $authors[]=array('ID' => $row['Author_ID'], 'Name'=>$row['Name']);
   }

try{
    $result= $pdo->query('SELECT ID, Name FROM Category');
}
catch (PDOException $e)
{
    $error = 'Error fetching categories from the database';
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
   {
       $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name']);
   }

try
{
    $sql = 'SELECT ID, RecipeText, Image FROM Recipe WHERE TRUE';
    $s = $pdo->prepare($sql);
    $s->execute(array());
}
catch (PDOException $e)
{
    $error = 'Error fetching recipes';
    include 'error.html.php';
    exit();
}
foreach ($s as $row)
{
    $recipes[]=array('ID' => $row['ID'], 'text'=>$row['RecipeText'], 'Image'=>$row['Image']);
}

include 'searchform.html.php';

?>