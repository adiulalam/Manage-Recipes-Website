<?php include_once '../admin/includes/helpers.inc.php'; ?> 
<!DOCTYPE html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <title>Log In</title>
 </head> 
 <body>
   <h1>Log In</h1>
   <p>Please log in to view the page that you requested.</p> 
   <?php if (isset($loginError)): ?>
     <p><?php echo($loginError); ?></p>
   <?php endif; ?>
   <form action="" method="post">
     <div>
      <label for="Email">Email: <input type="Text" name="Email" id="Email"></label><br/>
     </div> 
     <br/><div>
      <label for="Password">Password: <input type="Password" name="Password" id="Password"></label><br/>
     </div>
     <div>
      <input type="hidden" name="action" value="login">
      <input type="submit" value="Log in">
      <p><a href="forgotPassword.php">Forgot Password</a></p>
     </div>
   </form>
   <p><a href="../user/">Return to CMS home</a></p>
 </body> 
</html>

