<?php

if(!isset($_POST['message']))
{
    include 'mailform.html.php';
}

else
{
    include '../includes/db.inc.php';

try {
    $result= $pdo->query('SELECT * FROM Author');
}
catch (PDOException $e)
{
    $error = 'Error fetching authors from database';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $authors[]=array('ID' => $row['Author_ID'], 
                     'Name'=>$row['Name'], 
                     'Email'=>$row['Email']);
}

include 'message.html.php';
}

?>