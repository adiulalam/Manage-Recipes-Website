<?php include_once '../admin/includes/helpers.inc.php'; ?> 
<!DOCTYPE html>
<html lang="en">
 <head>
   <meta charset="utf-8">
   <title>Register</title>
          <script>
<!--
function validate_form ( )
{
	valid = true;

        if (document.contact_form.Name.value == "")
        {
                alert ( "Please fill in the 'Name' box." );
                valid = false;
        }
    
    if (document.contact_form.Email.value == "")
        {
                alert ( "Please fill in the 'Email' box." );
                valid = false;
        }
 
    
    if (document.contact_form.Password.value == "" || document.contact_form.Password.value.length < 6)
        {
                alert ( "Please fill in the 'Password' box and make sure it over 6 characters." );
                valid = false;
        }

        return valid;
}

//-->
</script>
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 </head> 
 <body>
   <h1>Register</h1>
   <form name="contact_form" action="?addform" method="post" onsubmit="return validate_form ();">
    <div><br/>
        <label for="Name">Name: <input type="text" name="Name"></label>
     </div>
     <div><br/>
         <label for="Email">Email: <input type="text" name="Email"></label>
     </div> 
     <div><br/>
         <label for="Password">Password: <input type="password" name="Password"></label>
     </div>
     <div>
    <br/>
      <div class="g-recaptcha" data-sitekey="6LeE-OEUAAAAANw3945K-hgOnyELcZOe_AwPghKW"></div>
    <br/>
      <input type="submit" name="submit" value="submit">
     </div>
   </form>
     

   <p><a href="../user/">Return to CMS home</a></p>
 </body> 
</html>
