<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
    
<div class="centered-container">
    <div class="registratieformulier">
        <form action="mailform.php" method="post">
          <div align="right"> 
          <h1><center><b>Contactformulier</b></center></h1>
              <hr width="100%">

	<?php
if (isset($_REQUEST['email']))
//if "email" is filled out, send email
  {
  //send email
  $email = $_REQUEST['email'] ;
  $onderwerp = $_REQUEST['subject'] ;
  $bericht = $_REQUEST['message'] ;
  mail("kirakiraboshi82@gmail.com", $subject,
  $message, "From:" . $email);
  echo "Thank you for using our mail form";
  }
else
//if "email" is not filled out, display the form
  {
  echo "<form method='post' action='mailform.php'>
  Email: <input name='email' type='text'><br>
  Subject: <input name='subject' type='text'><br>
  Message:<br>
  <textarea name='message' rows='15' cols='40'>
  </textarea><br>
  <input type='submit'>
  </form>";
  }
?>

              	
             
          
    </div>
</div>