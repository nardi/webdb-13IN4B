<!--
Klant komt op deze pagina terecht als hij op de contactformulierlink klikt. Deze pagina heeft als functie om
de klant input te vragen, en deze door te sturen naar ons emailadres.
-->

    
<div class="centered-container">
<div class="registratieformulier">

<h1><b>Contactformulier</b></h1>
<hr width="100%">

<?php
//deze functie geeft het formulier weer. 
function show_form()
{
echo "<form method='post' action='contactformulier.php'>
	Uw emailadres: <br /><input name='email' type='text' /><br />
	Onderwerp: <br /><input name='onderwerp' type='text' /><br />
	Bericht: <br />
	<textarea name='bericht' rows='15' cols='40'></textarea><br />
	<input type='submit' value='verstuur' />
	</form>"; 
}

//Hier wordt getest of het formulier volledig is ingevuld, en als deze is ingevuld dat worden
//De ingevoerde gegevens doorgestuurd naar contact@superinternetshop.nl
if (isset($_POST['email']) &&
	isset($_POST['onderwerp']) &&
	isset($_POST['bericht'])) {
		$email = $_REQUEST['email'] ;
		$onderwerp = $_REQUEST['onderwerp'] ;
		$bericht = $_REQUEST['bericht'] ;
		mail("contact@superinternetshop.nl", $onderwerp,
		$bericht, "From:" . $email);
  
	?><br /><div align="center">Hartelijk dank voor uw reactie, wij streven er naar uw vraag binnen 1 werkdag te beantwoorden.</div><?php
}
else {
  show_form();
}
?>
    
</div>
</div>