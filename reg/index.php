
<?php
    include 'form.html.php'; 

    if (isset($_POST['submit'])) {
        $Name = $_POST['Name'];
        $secretKey = "6LeE-OEUAAAAAAr3WTE8jt9EcyPU1MVOAwAh7UZ3";
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);
        if ($response->success)
            echo "Verification success.";
                if ($response->success)
        {
            include  '../admin/includes/db.inc.php';

            try
            {
                $sql = 'INSERT INTO Author SET Name = :Name, Email = :Email, Password= :Password';
                $s = $pdo->prepare($sql);
                $s->bindvalue(':Name', $_POST['Name']);
                $s->bindvalue(':Email', $_POST['Email']);
                $s->bindvalue(':Password', md5($_POST['Password'].'ijdb'));
                $s->execute();
            }
            catch (PDOException $e)
            {
                $error = 'Error adding submitted Author.';
                include 'error.html.php';
                exit();
            }

            $AuthorID = $pdo->lastInsertId();
                try {
                    $sql = 'INSERT INTO AuthorRole SET AuthorID= :AuthorID, RoleID= :RoleID'; 
                    $s = $pdo->prepare($sql); 
                    $s->bindValue(':AuthorID', $AuthorID); 
                    $s->bindValue(':RoleID', 'User'); 
                    $s->execute(); 
                } 
            catch (PDOException $e)
            {
                $error = 'Error assigning selected role to author.'; 
                include 'error.html.php'; 
                exit(); 
            }

        include 'welcome.html.php';
        }

        else
            echo "Verification failed!";
        
        $Email=$_POST['Email'];
  
      $msg='Your account has been registered. Thank you for registering';
      $sub='Register Successful';
      $header='From: register@form.co.uk';
      ini_set("SMTP", "smtp.gre.ac.uk");
      ini_set("sendmail_from", "aa6932u@gre.ac.uk");
      $m=mail($Email,$sub,$msg,$header);
    }
?>