<?php
error_reporting(0);
require_once '../includes/access.inc.php';

if (!userIsLoggedIn()){
	include '../login.html.php';
	exit();
}

if (userHasRole('Account Administrator') or userHasRole('Site Administrator'))
{

}
else
{
	$error =  'Only Account Administrators or Site Administrator may access this page.';
	include '../accessdenied.html.php';
	exit();
}

//new Author form
if (isset($_GET['add']))
{
	include  '../includes/db.inc.php';
	$pageTitle = 'New Author';
	$action = 'addform';
	$Name = '';
	$Email = '';
	$ID = '';
	$button = 'Add Author';

//build list of Roles
	try
	{
		$result = $pdo->query('SELECT ID, Description FROM Role');
	}
	catch (PDOException $e)
	{
		$error = 'Error fetching list of Roles.';
		include 'error.html.php';
		exit();
	}
	foreach ($result as $row)
	{
		$Roles[] = array('ID' => $row['ID'], 'Description' => $row['Description'], 'selected' => FALSE);
	}


	include 'form.html.php';
	exit();
}
//insert new Author
if (isset($_GET['addform']))
{
	include  '../includes/db.inc.php';
	try
	{
		$sql = 'INSERT INTO Author SET Name = :Name, Email = :Email';
		$s = $pdo->prepare($sql);
		$s->bindvalue(':Name', $_POST['Name']);
		$s->bindvalue(':Email', $_POST['Email']);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Error adding submitted Author.';
		include 'error.html.php';
		exit();
	}

	$AuthorID = $pdo->lastInsertId();

	if ($_POST['Password'] != '')
	{
		$Password = md5($_POST['Password'].'ijdb');

		try
		{
			$sql = 'UPDATE Author SET
				Password = :Password
				WHERE Author_ID = :ID';
			$s = $pdo->prepare($sql);
			$s->bindvalue(':Password', $Password);
			$s->bindvalue(':ID', $AuthorID);
			$s->execute();
		}
		catch (PDOException $e)
		{
			$error = 'Error setting Author Password.';
			include 'error.html.php';
			exit();
		}
	}

	if (isset($_POST['Roles']))
	{
		foreach ($_POST['Roles'] as $Role) {
			try
			{
			$sql = 'INSERT INTO AuthorRole SET
				AuthorID = :AuthorID,
				RoleID = :RoleID';
			$s = $pdo->prepare($sql);
			$s->bindValue(':AuthorID', $AuthorID);
			$s->bindValue(':RoleID', $Role);
			$s->execute();
			}
			catch (PDOException $e)
		{
			$error = 'Error assigning selected Role to Author.';
			include 'error.html.php';
			exit();
		}
		}
	}

	header('Location: .');
	exit();
}
//edit authors
if(isset($_POST['action']) and $_POST['action'] == 'Edit')
{
	include  '../includes/db.inc.php';
	try
	{
	$sql = 'SELECT Author_ID, Name, Email FROM Author WHERE Author_ID = :ID';
	$s = $pdo->prepare($sql);
	$s->bindvalue(':ID', $_POST['ID']);
	$s->execute();
}
catch (PDOException $e)
{
	$error = 'Error fetching Author details.';
	include 'error.html.php';
	exit();
}
//populate form
$row = $s->fetch();

	$pageTitle = 'Edit Author';
	$action = 'editform';
	$Name = $row['Name'];
	$Email = $row['Email'];
	$ID = $row['Author_ID'];
	$button = 'update Author';

	//get list of Roles assigned to this Author
	 try
  {
    $sql = 'SELECT RoleID FROM AuthorRole WHERE AuthorID = :ID';
    $s = $pdo->prepare($sql);
    $s->bindValue(':ID', $ID);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of assigned Roles.';
    include 'error.html.php';
    exit();
  }
  $selectedRoles = array();
  foreach ($s as $row)
  {
    $selectedRoles[] = $row['RoleID'];
  }

  // Build the list of all Roles
  try
  {
    $result = $pdo->query('SELECT ID, Description FROM Role');
  }
  catch (PDOException $e)
  {
    $error = 'Error fetching list of Roles.';
    include 'error.html.php';
    exit();
  }
  foreach ($result as $row)
  {
    $Roles[] = array(
      'ID' => $row['ID'],
      'Description' => $row['Description'],
      'selected' => in_array($row['ID'], $selectedRoles));
  }

include 'form.html.php';
exit();
}

//update the authors details
if (isset($_GET['editform']))
{
	include  '../includes/db.inc.php';
	try
	{
		$sql = 'UPDATE Author SET
		Name = :Name,
		Email = :Email WHERE Author_ID = :ID';
		$s = $pdo->prepare($sql);
		$s->bindvalue(':ID', $_POST['ID']);
		$s->bindvalue(':Name', $_POST['Name']);
		$s->bindvalue(':Email', $_POST['Email']);
		$s->execute();
	}
	catch (PDOException $e)
{
	$error = 'Error updating submitted Author.';
	include 'error.html.php';
	exit();
}
if ($_POST['Password'] != '')
  {
    $Password = md5($_POST['Password'].'ijdb');
    try
    {
      $sql = 'UPDATE Author SET
          Password = :Password
          WHERE Author_ID = :ID';
      $s = $pdo->prepare($sql);
      $s->bindValue(':Password', $Password);
      $s->bindValue(':ID', $_POST['ID']);
      $s->execute();
    }
    catch (PDOException $e)
    {
      $error = 'Error setting Author Password.';
      include 'error.html.php';
      exit();
    }
  }
  try
  {
    $sql = 'DELETE FROM AuthorRole WHERE AuthorID = :ID';
    $s = $pdo->prepare($sql);
    $s->bindValue(':ID', $_POST['ID']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing obsolete Author Role entries.';
    include 'error.html.php';
    exit();
  }
  if (isset($_POST['Roles']))
  {
    foreach ($_POST['Roles'] as $Role)
    {
      try
      {
        $sql = 'INSERT INTO AuthorRole SET
            AuthorID = :AuthorID,
            RoleID = :RoleID';
        $s = $pdo->prepare($sql);
        $s->bindValue(':AuthorID', $_POST['ID']);
        $s->bindValue(':RoleID', $Role);
        $s->execute();
      }
      catch (PDOException $e)
      {
        $error = 'Error assigning selected Role to Author.';
        include 'error.html.php';
        exit();
      }
    }
  }



header('Location: .');
exit();

}


//delete confirm - ask if certain?
if(isset($_POST['action']) and $_POST['action'] == 'Delete'){
	include  '../includes/db.inc.php';
   //list all authors
try{
	$sql = 'SELECT Author_ID, Name FROM Author WHERE Author_ID = :ID';
	$s = $pdo->prepare($sql);
	$s->bindvalue(':ID', $_POST['ID']);
	$s->execute();
}
catch (PDOException $e)
{
	$error = 'Error fetching Author from the database';
	include 'error.html.php';
	exit();
}
//fetch the Author row from the sent ID
$row = $s->fetch();

	$Name = $row['Name'];
	$ID = $row['Author_ID'];

include 'confirm_delete.html.php';
exit();
	
}


 //delete Author, his jokes and link table data

if(isset($_POST['action']) and $_POST['action'] == 'Yes')
{
	include '../includes/db.inc.php';

 // Delete Role assignments for this Author

	 try
  {
    $sql = 'DELETE FROM AuthorRole WHERE AuthorID = :ID';
    $s = $pdo->prepare($sql);
    $s->bindValue(':ID', $_POST['ID']);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error removing Author from Roles.';
    include 'error.html.php';
    exit();
  }

 
try{
	$sql = 'DELETE FROM Author WHERE Author_ID = :ID';
	$s = $pdo->prepare($sql);
	$s->bindvalue(':ID', $_POST['ID']);
	$s->execute();
}
catch (PDOException $e)
{
	$error = 'Error deleting Author.';
	include 'error.html.php';
	exit();
}
header('Location: .');
exit();

}
// if no return to main list
if(isset($_POST['action']) and $_POST['action'] == 'No')
{
	header('Location: .');
	exit();
}



include '../includes/db.inc.php';

try{
    $result= $pdo->query('SELECT Author_ID, Name, Email, Image From Author'); //selects id, name, email and images
}
catch (PDOException $e)
{
    $error = 'Error fetching authors from the database';
    include 'error.html.php';
    exit();
}


foreach ($result as $row) //makes it a variable
   {
       $authors[]=array('ID' => $row['Author_ID'], 'Name'=>$row['Name'],'Email'=>$row['Email'], 'Image'=>$row['Image']);
   }
include 'authors.html.php'; //goes to authors

