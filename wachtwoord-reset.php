<!--
Als de klant op de link in de email klikt komt hij/zij op deze pagina terecht.
Met de link is een "token" en een "id" meegegeven die gechecked worden op geldigheid.
-->

<div class="centered-container">
<div class="wachtwoord-vergeten">
<div align="right"> 
<h1><CENTER><b>Wachtwoord Resetten</b></CENTER></h1>
<hr width="100%">
<br />
    
<?php
//Deze functie geeft hetformulier weer dat ingevuld kan worden op de pagina.
//De token wordt hier als een hidden variabele meegegeven met het formulier
//zodat deze ook nog bekend is bij het herladen van deze file als er op 'verstuur' wordt gedrukt.
function show_form()
{  
$token = ($_GET['token']);
echo "<form method='post' action='wachtwoord-reset.php'>
	<input name='token' type='hidden' value='$token' />
	Wachtwoord: <input name='wachtwoord' type='password' /><br />
	Wachtwoord nogmaals: <input name='wachtwoord_nogmaals' type='password' /><br />
	</textarea><br />
	<input type='submit' value='verstuur' />
	</form>";
}

if (!isset($_POST['wachtwoord'])&&
	!isset($_POST['wachtwoord_nogmaals'])) {
	
	//Hier wordt aan de hand van het meegegeven id gekeken wat de token in de db is.
	//vervolgens wordt gekeken of deze nog gelijk is aan de token die is meegegeven met de link.
	//als een klant een ww al heeft aangepast dan is de token in de database namelijk leeg
	//en kan hij niet meer aangepast worden.
	
	$db = connect_to_db();
    $token = ($_GET['token']);
	$id = ($_GET['id']);
    $sql3 = $db->prepare("SELECT wachtwoord_token FROM Gebruikers WHERE id = ? LIMIT 1");
	$sql3->bind_param("s", $id);
	$sql3->bind_result($token_db);
	$sql3->execute();
	$sql3->fetch();

	//Hier wordt getest of de token in de database voor het meegegeven id overeenkomt met het meegegeven token.
	if ($token_db === $token) {
	
		echo "<div align='justify'>
		Vul hieronder het door u nieuwe gekozen wachtwoord in. 
		</div><br /><br />";
		show_form();
	
	} else {
		?><div class="centered-container">Deze link is verlopen</div><?php
	}
	
} else {
	
	//hier wordt gecontroleerd of het oude wachtwoord juist is, 
	//en zo ja dan wordt het nieuwe wachtwoord gesalt en gahashed en wordt deze weggeschreven naar de db.
	
	if ($_POST['wachtwoord'] === $_POST['wachtwoord_nogmaals']) {
		$token = $_POST['token'] ;
		$wachtwoord = $_POST['wachtwoord_nogmaals'] ;
		$saltww = maak_wachtwoord($wachtwoord);

		//Hier wordt het wachtwoord naar de database geschreven
		$db = connect_to_db();
		$sql = $db->prepare("UPDATE Gebruikers SET wachtwoord = '$saltww' WHERE wachtwoord_token = ? LIMIT 1");
		$sql->bind_param("s", $token) ;
		$sql->execute();

		//Hier wordt de token verwijderd uit de database
		$sql2 = $db->prepare("UPDATE Gebruikers SET wachtwoord_token = NULL WHERE wachtwoord_token = ? LIMIT 1");
		$sql2->bind_param("s", $token) ;
		$sql2->execute();
		echo "Uw wachtwoord is aangepast, hartelijk dank!" ;
		?>
		<!--
		session timeout toegevoegd, klant gaat terug naar de index.
		-->
		<script type="text/JavaScript">
			setTimeout("location.href = '/index.php';",3000);
		</script>
		<?php
	  
	} else {
		//Als klant geen overeenkomstige wachtwoorden heeft ingevoerd dan wordt het formulier nogmaals weergegeven.
		$token = $_POST['token'] ;
		echo "<div align='justify'>
		Vul hieronder nogmaals het door u nieuwe gekozen wachtwoord in. 
		</div><br /><br />";
		show_form();
	  
	}
} 
	  
?>
</div>
</div>
</div>