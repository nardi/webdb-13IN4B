<link rel="stylesheet" type="text/css" href="contactformulier.css">
    
<div class="centered-container">
  <div class="registratieformulier">
    <div align="right"> 
  <h1><center><b>Contactformulier</b></center></h1>
  <hr width="100%">

<?php
function show_form()
{
echo "<form method='post' action='contactformulier.php'>
Email: <input name='email' type='text'><br />
Onderwerp: <input name='onderwerp' type='text'><br />
Bericht:<br />
<textarea name='bericht' rows='15' cols='40'>
</textarea><br />
<input type='submit' value='verstuur'>
</form>"; 
}
?>
 
<?php
if (isset($_REQUEST['email'])){
  $email = $_REQUEST['email'] ;
  $onderwerp = $_REQUEST['onderwerp'] ;
  $bericht = $_REQUEST['bericht'] ;
  mail("contact@superinternetshop.nl", $onderwerp,
  $bericht, "From:" . $email);
  echo "<div align="center">Hartelijk dank voor uw reactie, wij streven er naar uw vraag binnen 1 werkdag te beantwoorden</div>";
}
else {
  show_form();
}
?>
    </div>
  </div>
</div>