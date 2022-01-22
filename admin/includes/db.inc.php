<?php
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
?>