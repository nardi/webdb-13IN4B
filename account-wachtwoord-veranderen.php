<!--
Als de klant in mijn account op de button "wachtwoord veranderen" klikt dan komt hij op deze pagina terecht.
De functionaliteit van deze pagina is om eerst het oude wachtwoord te vragen, vervolgens 2 keer de nieuwe
Er wordt dan gecontroleerd of deze 2 maal hetzelfde is ingevult, en als al deze condities kloppen
dan wordt het nieuwe wachtwoord weggeschreven naar de database.
-->

<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<div class="centered-container">
<div class="account-wachtwoord-veranderen">
<div align="right"> 
 
<h1><center><b>Mijn account</b></center></h1>
<hr width="100%">
<center><b>Wachtwoord veranderen</b></center>
<br />

<?php
//Deze functie geeft een furmulier weer waarin het oude wachtwoord en het nieuwe wachtwoord (2x) wordt gevraagd.
function show_form()
{
echo "<form method='post' action='account-wachtwoord-veranderen.php'>
Oud wachtwoord: <input type='password' name='oud_wachtwoord'><br />
Nieuw wachtwoord: <input type='password' name='nieuw_wachtwoord'><br />
Nieuw wachtwoord bevestigen: <input type='password' name='nieuw_wachtwoord_nogmaals'><br />
<input type='submit' value='Wachtwoord veranderen'>
</form>";
}
?>

<?php
//Eerst wordt er gecontroleerd of de klant wel is ingelogged door te checken of er een lopende session is.
if (!isset($_SESSION['logged-in'])) {
	
	?>
	<pre>
	U bent niet ingelogd!
	</pre>
	<?php

} else {
	
	//als het formulier volledig is ingevuld dan wordt onderstaande reeks uitgevoerd.
	if (isset($_POST['oud_wachtwoord'])&&
		!empty($_POST['nieuw_wachtwoord']) &&
		isset($_POST['nieuw_wachtwoord'])&&
		isset($_POST['nieuw_wachtwoord_nogmaals'])) {
		
		$db = connect_to_db();
		
		$id = $_SESSION['gebruiker-id'] ;
		$wachtwoord = $_POST['oud_wachtwoord'];
		$nieuw_wachtwoord = $_POST['nieuw_wachtwoord'];
		$nieuw_wachtwoord_nogmaals = $_POST['nieuw_wachtwoord_nogmaals'];
		
		$sql = $db->prepare("SELECT wachtwoord FROM Gebruikers WHERE id = ? LIMIT 1");
		$sql->bind_param("s", $id);
		$sql->execute();
		$sql->bind_result($wwdb);
		$sql->fetch();
		sleep(2);
		
		//Hier wordt gecontroleerd of het wachtwoord uit de database overeenkomt met het wachtwoord dat
		//is opgegeven bij "oud wachtwoord" met de functie 'check_wachtwoord()'
		if (check_wachtwoord($wachtwoord, $wwdb)) {
			
			if ($nieuw_wachtwoord === $nieuw_wachtwoord_nogmaals) {
				
				//Random getal voor salt genereren
				$saltbytes = openssl_random_pseudo_bytes(32);
				$salt = bin2hex($saltbytes);

				//Hashen met SHA-256
				$wwhash = hash('sha256', $nieuw_wachtwoord);
				$saltedwwhash = hash('sha256', $salt . $wwhash);

				//Combinatie salt en wachtwoordhash voor database
				$saltww = $salt . $saltedwwhash;

				//Hier wordt het wachtwoord naar de database geschreven
				$db = connect_to_db();
				$sql = $db->prepare("UPDATE Gebruikers SET wachtwoord = '$saltww' WHERE id = ? LIMIT 1");
				$sql->bind_param("s", $id) ;
				$sql->execute();
				
				
				echo "Uw wachtwoord is nu aangepast." ;
				
					
			} else {
				
				echo "U heeft niet 2 maal hetzelfde wachtwoord ingevoerd. Probeer het nogmaals!" ;
				show_form();
			}
			
		} else {
			
			echo "Fout wachtwoord ingevuld. Probeer het opnieuw ";
			show_form();
			
		}
	
	//Als er nog niets is ingevuld dan wordt de 'show_form()' functie aangeroepen om het formulier weer te geven.
	} else {
		
		show_form();
	}	
}
?>
<br />
<br />    
</div>
</div>
</div>