<?php
require_once '../includes/access.inc.php';

if (!userIsLoggedIn()){ 
    include '../login.html.php'; 
    exit();
} 

if (userHasRole('Site Administrator'))
{

}
else
{
    $error='Only Site Administrators may access this page.'; 
    include '../accessdenied.html.php'; 
    exit(); 
}

if(isset($_GET['add']))
{
    $pageTitle = 'New Category';
    $action = 'addform';
    $Name='';
    $ID='';
    $button='Add Category';
    
    include 'form.html.php';
    exit();
}

if(isset($_GET['addform']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'INSERT INTO Category SET Name=:Name';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':Name', $_POST['Name']);
        $s->execute();
    }
catch (PDOException $e)
{
    $error = 'Error adding submitted category';
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}

if(isset($_POST['action']) and $_POST['action']=='Edit')
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'SELECT ID, Name FROM Category WHERE ID= :ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->execute();
    }
catch (PDOException $e)
{
    $error = 'Error fetching category details';
    include 'error.html.php';
    exit();
}
    
$row = $s->fetch();
    $pageTitle='Edit Category';
    $action='editform';
    $Name=$row['Name'];
    $ID=$row['ID'];
    $button='Update category';
include 'form.html.php';
exit();
}
  
if(isset($_GET['editform']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'UPDATE Category SET
        Name=:Name
        WHERE ID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':Name', $_POST['Name']);
        $s->execute();
    }
catch (PDOException $e)
{
    $error = 'Error adding submitted category';
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}

///////
if(isset($_POST['action']) and $_POST['action']=='Delete'){
include '../includes/db.inc.php';
   
try{
    $sql= 'SELECT CategoryID FROM RecipeCategory WHERE CategoryID = :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error removing recipes from category';
    include 'error.html.php';
    exit();
}


try{
    $sql= 'SELECT ID FROM Category WHERE ID = :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting category';
    include 'error.html.php';
    exit();
}
    $row = $s->fetch();
    $ID=$row['ID'];
    
include 'confirm_delete.html.php';
exit();
}
///////
if(isset($_POST['action']) and $_POST['action']=='Yes')
{
    include '../includes/db.inc.php';
try{
    $sql= 'DELETE FROM RecipeCategory WHERE CategoryID = :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error removing category from recipecategory';
    include 'error.html.php';
    exit();
}


try{
    $sql= 'DELETE FROM Category WHERE ID = :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting category';
    include 'error.html.php';
    exit();
}
    
header('Location: .');
exit();
}

/////

include '../includes/db.inc.php';

try{
    $result= $pdo->query('SELECT ID, Name, Image From Category');
}
catch (PDOException $e)
{
    $error = 'Error fetching categories from the database';
    include 'error.html.php';
    exit();
}


foreach ($result as $row)
   {
       $categories[]=array('ID' => $row['ID'], 'Name' => $row['Name'],'Image'=>$row['Image']);
   }
    
include 'categories.html.php';
   
?>