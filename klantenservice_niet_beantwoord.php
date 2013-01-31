<!--
Klant komt op deze pagina terecht als zijn vraag via de interactieve klantenservice niet is beantwoord.
-->

<?php
//deze functie geeft het formulier weer. 
function show_form()
{
echo "Uw gegevens worden automatisch met het bericht meegestuurd naar onze klantenservice!";
echo "<form method='post' action='klantenservice_niet_beantwoord.php'>
	<br /><br />
	Bericht:<br />
	<textarea name='bericht' rows='15' cols='40'>
	</textarea><br />
	<input type='submit' value='verstuur' />
	<br /><br />
	</form>"; 
}

//Er word getest of de klant is ingelogd
if (!isset($_SESSION['logged-in'])) {
	?>
	<pre>
	U bent niet ingelogd!
	</pre>
	<?php
} else {
	?>
	<div class="centered-container"> 
	<div class="account-wachtwoord-veranderen">
	<h1><center><b>Klantenserviceformulier</b></center></h1>
	<hr width="100%"><br />

	<?php


	//als formulier is ingevuld dan worden de gegevens verstuurd. Vanuit de session worden de klantgegevens opgehaald 
	//waardoor de klantgegevens samen met het bericht naar de klantenservice worden verstuurd.
	if (isset($_POST['bericht'])) {

		$id = $_SESSION['gebruiker-id'] ;
		$naam = $_SESSION['gebruiker-naam'] ;
		$onderwerp = "Vraag niet beantwoord" ;

		$db = connect_to_db();

		$sql = $db->prepare("SELECT email FROM Gebruikers WHERE id = ? LIMIT 1");
		$sql->bind_param("s", $id);
		$sql->execute();
		$sql->bind_result($email);
		$sql->fetch();


		$bericht = $_POST['bericht'] ;
		mail("contact@superinternetshop.nl", $onderwerp,
		$bericht, "From:" . $email);

		?><br /><div align="center">Hartelijk dank voor uw reactie, wij streven er naar uw vraag binnen 1 werkdag te beantwoorden.<br /><br /></div><?php
	} else {
		show_form();
	}
}
?>