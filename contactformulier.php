<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
    
<div class="centered-container">
    <div class="registratieformulier">
      
          <h1><center><b>Contactformulier</b></center></h1>
              <hr width="100%">

	<?php
if (isset($_REQUEST['email']))
//if "email" is filled out, send email
  {
  //send email
  $email = $_REQUEST['email'] ;
  $onderwerp = $_REQUEST['onderwerp'] ;
  $bericht = $_REQUEST['bericht'] ;
  
  mail("superinternetshop@gmail.com", $onderwerp,
  $bericht, "From:" . $email);



  
  echo "Thank you for using our mail form";
  }
else
//if "email" is not filled out, display the form
  {
  echo "<form method='post' action='contactformulier.php'>
  Email: <input name='email' type='text'><br>
  Onderwerp: <input name='onderwerp' type='text'><br>
  Bericht:<br>
  <textarea name='bericht' rows='15' cols='40'>
  </textarea><br>
  <input type='submit'>
  </form>";
  }
?>

              	
             
          
    </div>
</div>