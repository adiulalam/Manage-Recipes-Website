<?php
//error_reporting(0);

if (isset($_GET['addrecipe']))
{
    include 'form.html.php';
    exit();
}

if (isset($_POST['RecipeText']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'INSERT INTO Recipe SET
            RecipeText = :RecipeText,
            RecipeDate= CURDATE()';
        $s=$pdo->prepare($sql);
        $s->bindValue(':RecipeText', $_POST['RecipeText']);
        $s->execute();
    }

catch (PDOException $e)
{
    $error = 'Error adding submitted recipe' . $e->getMessage();
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}

if(isset($_GET['deleterecipe']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'DELETE FROM Recipe WHERE ID = :ID';
        $s =$pdo->prepare($sql);
        $s->bindValue(':ID', $_POST['ID']);
        $s->execute();
    }

catch (PDOException $e)
{
    $error = 'Error deleting recipe' . $e->getMessage();
    include 'error.html.php';
    exit();
}
header('Location: .');
exit();
}

try
{
    $pdo= new PDO('mysql:host=mysql.cms.gre.ac.uk;dbname=mdb_aa6932u', 'aa6932u', 'aa6932u');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
}
catch(PDOException $e)
{
    $error= 'Unable to connect to database server:' . $e->getMessage();
    //$error= 'Unable to connect to database server:';
    include 'error.html.php';
    exit();
}

include '../includes/db.inc.php';
try 
{
    $sql= 'SELECT Recipe.ID, RecipeText, RecipeDate, Name, Email 
    FROM Recipe INNER JOIN Author 
    ON AuthorID = Author_ID';
    $result=$pdo->query($sql);
}
catch (PDOException $e)
{
    $error= 'Error fetching recipes' . $e->getMessage();
    include 'error.html.php';
    exit();
}

foreach($result as $row)
{
    $recipes[]= array(
    'ID'=> $row['ID'],
    'RecipeText'=> $row['RecipeText'],
    'RecipeDate'=> $row['RecipeDate'],
    'Name'=> $row['Name'],
    'Email'=>$row['Email']
    );
}
include 'recipes.html.php';

//$error= 'Database connection established';
//include 'error.html.php';

?>