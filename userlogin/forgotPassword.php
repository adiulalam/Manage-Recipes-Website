
<html>
	<body>
		<form method="post">
            <p>Email: 
			<input type="text" name="Email"></p>
			<input type="submit" name="submit">
		</form>
        <p><a href="../user">Return to CMS home</a></p>
	</body>
</html>

<?php
if(isset($_POST['submit'])) 
{

include '../admin/includes/db.inc.php';
$Email=$_POST['Email'];
    try
  {
    $sql = 'SELECT Password FROM Author
        WHERE Email = :Email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':Email', $Email);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error searching for Email.';
    include 'error.html.php';
    exit();
  }
  $row = $s->fetch();
  $Password = md5($row['Password']);
    
  $Pass = md5(md5($row['Password']).'ijdb');
    
    try
    {
        $sql = 'UPDATE Author SET
        Password=:Password
        WHERE Email=:Email';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':Email', $Email);
        $s->bindvalue(':Password', $Pass);
        $s->execute();
    }
    catch (PDOException $e)
    {  
        $error = 'Error updating password';
        include 'error.html.php';
        exit();
    }
  
  $msg='Your password is '.$Password;
  $sub='New password';
  $header='From: resetpassword@pasword.ac.uk';
ini_set("SMTP", "smtp.gre.ac.uk");
ini_set("sendmail_from", "aa6932u@gre.ac.uk");
  $m=mail($Email,$sub,$msg,$header);
  if($m)
  {
   echo ('check your mail');
  }
    else
    {
        echo ('Please check the email input');
    }
 }


