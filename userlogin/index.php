<?php
error_reporting(0);
require_once '../admin/includes/access.inc.php';

if (!userIsLoggedIn()){ 
    include 'login.html.php'; 
    exit();
} 
customer();

if (!userHasRole('User'))
{
    $error='Only signed up users may access this page.';
    include '../admin/accessdenied.html.php'; 
    exit(); 
}
/*****************************************************/
//Add new Recipe

if(isset($_GET['add']))
{
    $pageTitle = 'New Recipe';
    $action = 'addform';
    $text='';
    $AuthorID='';
    $ID='';
    $button='Add Recipe';
    
    include '../admin/includes/db.inc.php';
    
    try
    {
        $result= $pdo->query('SELECT Author_ID, Name FROM Author');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of authors';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row){
    $authors[]= array('ID' => $row['Author_ID'], 'Name'=>$row['Name'] );
}
    
//build list of categories    
     try
    {
        $result= $pdo->query('SELECT ID, Name FROM Category');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of categories';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => FALSE );
}

include 'form.html.php';
exit();
}

/*****************************************************/
//Insert recipe

if(isset($_GET['addform']))
{
    include '../admin/includes/db.inc.php';
    
    if($_POST['Author']=='')
    {
        $error='You must choose an author for this recipe, Click back and try again';
        include 'error.html.php';
        exit();
    }
    
    try
    {
    require_once '../admin/includes/HTMLPurifier.standalone.php';
    $purifier = new HTMLPurifier();
    $clean=$purifier->purify($_POST['text']);
            
            
        $sql = 'INSERT INTO Recipe SET
        RecipeText=:RecipeText,
        RecipeDate=CURDATE(),
        AuthorID=:AuthorID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':RecipeText', $clean);
        $s->bindvalue(':AuthorID', $_POST['Author']);
        $s->execute();
    }
    
        catch (PDOException $e)
{
    $error = 'Error adding submitted recipe';
    include 'error.html.php';
    exit();
}

$RecipeID = $pdo->lastInsertId();


/*****************************************************/
//Insert record into jokecategory table

if(isset($_POST['categories']))
{
    try
    {
        $sql = 'INSERT INTO RecipeCategory SET
        RecipeID=:RecipeID,
        CategoryID=:CategoryID';
        $s =$pdo->prepare($sql);
        foreach ($_POST['categories'] as $CategoryID)
        {
            $s->bindvalue(':RecipeID', $RecipeID);
            $s->bindvalue(':CategoryID', $CategoryID);
            $s->execute();
        }
    }
catch (PDOException $e)
{
    $error = 'Error inserting recipe into selected categories';
    include 'error.html.php';
    exit();
}
}
header('Location: .');
exit();
}

/*****************************************************/
//edit recipe button been clicked

if(isset($_POST['action']) and $_POST['action']=='Edit')
{
    include '../admin/includes/db.inc.php';
try
{
    $sql = 'SELECT ID, RecipeText, AuthorID FROM Recipe WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching recipe details';
    include 'error.html.php';
    exit();
}
    
$row = $s->fetch();
    $pageTitle='Edit Recipe';
    $action='editform';
    $text=$row['RecipeText'];
    $AuthorID=$row['AuthorID'];
    $ID=$row['ID'];
    $button='Update Recipe';
    
    //build list of authors
    try
    {
        $result= $pdo->query('SELECT Author_ID, Name FROM Author');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of authors';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $authors[]=array('ID' => $row['Author_ID'], 'Name'=>$row['Name'] );
}
    
//get list of categories containing this recipe
    
try
{
    $sql = 'SELECT CategoryID FROM RecipeCategory WHERE RecipeID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $ID);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching lists of selected categories';
    include 'error.html.php';
    exit();
}
    
foreach ($s as $row)
{
    $selectedCategories[]=$row['CategoryID'];
}

/*****************************************************/
//build list of categories  

    try
    {
        $result= $pdo->query('SELECT ID, Name FROM Category');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of categories';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => in_array($row['ID'], $selectedCategories));
}

//show the edit recipe version of the form
include 'form.html.php';
exit();
}
    
/*****************************************************/
//update the edited recipe

if(isset($_GET['editform']))
{
    include '../admin/includes/db.inc.php';
    
    if($_POST['Author'] == '')
    {
        $error='You must choose an author for this recipe, Click back and try again';
        include 'error.html.php';
        exit();
    }
    
    try
    {
        $sql = 'UPDATE Recipe SET
        RecipeText=:RecipeText,
        AuthorID=:AuthorID
        WHERE ID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':RecipeText', $_POST['text']);
        $s->bindvalue(':AuthorID', $_POST['Author']);
        $s->execute();
    }
    
    catch (PDOException $e)
{
    $error = 'Error updating submitted recipe';
    include 'error.html.php';
    exit();
}

 try
    {
        $sql = 'DELETE FROM RecipeCategory WHERE RecipeID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->execute();
    }
    
    catch (PDOException $e)
{
    $error = 'Error removing obsolete recipe category entries';
    include 'error.html.php';
    exit();
}
if(isset($_POST['categories']))
{    
try
    {
        $sql = 'INSERT INTO RecipeCategory SET 
        RecipeID= :RecipeID, 
        CategoryID=:CategoryID';
        $s =$pdo->prepare($sql);
        foreach ($_POST['categories'] as $CategoryID)
        {
            $s->bindvalue(':RecipeID', $_POST['ID']);
            $s->bindvalue(':CategoryID', $CategoryID);
            $s->execute();
        }
    }
    
    catch (PDOException $e)
{
    $error = 'Error inserting recipe into selected categories';
    include 'error.html.php';
    exit();
}
}
    
header('Location: .');
exit();
}


/*****************************************************/
//delete the recipe

if(isset($_POST['action']) and $_POST['action']=='Delete')
{
    include '../admin/includes/db.inc.php';
try
{
    $sql = 'SELECT RecipeID FROM RecipeCategory WHERE RecipeID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting recipe from categories';
    include 'error.html.php';
    exit();
}
    
//delete the recipe
try
{
    $sql = 'SELECT ID, RecipeText FROM Recipe WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching recipe';
    include 'error.html.php';
    exit();
}
    $row = $s->fetch();
    $RecipeText=$row['RecipeText'];
    $ID=$row['ID'];
    
include 'confirm_delete.html.php';
exit();
}
//delete the recipe

if(isset($_POST['action']) and $_POST['action']=='Yes')
{
    include '../admin/includes/db.inc.php';
try
{
    $sql = 'DELETE FROM RecipeCategory WHERE RecipeID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error removing recipe from categories';
    include 'error.html.php';
    exit();
}
    
//delete the recipe
try
{
    $sql = 'DELETE FROM Recipe WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting recipe';
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}


/*****************************************************/


if(isset($_GET['action']) and $_GET['action']=='search')
{
    include '../admin/includes/db.inc.php';
    
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

include '../admin/includes/db.inc.php';
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

include 'searchform.html.php';

//********************

?>