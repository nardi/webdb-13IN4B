<link rel="stylesheet" type="text/css" href="contactformulier.css">
    
<div class="centered-container">
  <div class="registratieformulier">
    <div align="right"> 
  <h1><center><b>Contactformulier</b></center></h1>
  <hr width="100%">

<?php
if (isset($_REQUEST['email'])){
  $email = $_REQUEST['email'] ;
  $onderwerp = $_REQUEST['onderwerp'] ;
  $bericht = $_REQUEST['bericht'] ;
  mail("superinternetshop@gmail.com", $onderwerp,
  $bericht, "From:" . $email);
  echo "Hartelijk dank voor uw reactie, wij streven er naar uw vraag binnen 1 werkdag te beantwoorden";
}
else {
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
</div>