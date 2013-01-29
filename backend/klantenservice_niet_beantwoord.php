<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<script>
//deze functie geeft het formulier weer. 
function show_form()
{
echo "<form method='post' action='klantenservice_factuur_niet_beantwoord.php'>
	
	Bericht:<br />
	<textarea name='bericht' rows='15' cols='40'>
	</textarea><br />
	<input type='submit' value='verstuur'>
	</form>"; 
}
</script>

<body>

<?php
	if ((!isset($_SESSION['logged-in']))) {
		?>
		<pre>
		U bent niet ingelogd!
		</pre>
		<?php
	} else {
		?>
		<div class="account-wachtwoord-veranderen">
		<div class="centered-container"> 
		<h1><center><b>Klantenservice</b></center></h1>
		<hr width="100%">
		
		<br />
		
		<?php


//als alles is ingevuld dan wordt de email verstuurd.
if (isset($_POST['bericht']) {

	$id = $_SESSION['gebruiker-id'] ;
	$naam = $_SESSION['gebruiker-naam'] ;
	$onderwerp = "Factuur" ;
	
	$db = connect_to_db();
	
	$sql = $db->prepare("SELECT email FROM Gebruikers WHERE id = ? LIMIT 1");
	$sql->bind_param("s", $id);
	$sql->execute();
	$sql->bind_result($email);
	$sql->fetch();

	
	$bericht = $_POST['bericht'] ;
	mail("contact@superinternetshop.nl", $onderwerp,
	$bericht, "From:" . $email);
  
	?><br /><div align="center">Hartelijk dank voor uw reactie, wij streven er naar uw vraag binnen 1 werkdag te beantwoorden.</div><?php
}
else {
  show_form();
}
?>