<!--
Als de klant op de link in de email klikt komt hij/zij op deze pagina terecht.
Met de link is een "token" en een "id" meegegeven die gechecked worden op geldigheid.
-->

<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">

<div class="centered-container">
  <div class="wachtwoord-vergeten">
    <div align="right"> 
  <h1><CENTER><b>Wachtwoord Resetten</b></CENTER></h1>
  <hr width="100%">
    <br />
    
<?php
function show_form()
{  
$token = ($_GET['token']);
echo "<form method='post' action='wachtwoord-reset.php'>
	<input name='token' type='hidden' value='$token'>
	Wachtwoord: <input name='wachtwoord' type='password'><br />
	Wachtwoord nogmaals: <input name='wachtwoord_nogmaals' type='password'><br />
	</textarea><br />
	<input type='submit' value='verstuur'>
	</form>";
}

if (!isset($_POST['wachtwoord'])&&
	!isset($_POST['wachtwoord_nogmaals'])) {
	
	//hier wordt aan de hand van het meegegeven id gekeken wat de token in de db is.
	//vervolgens wordt gekeken of deze nog gelijk is aan de token die is meegegeven met de link.
	//als een klant een ww al heeft aangepast dan is de token in de database namelijk leeg
	//en kan hij niet meer aangepast worden.
	
	$db = connect_to_db();
    $token = ($_GET['token']);
	$id = ($_GET['id']);
    $sql3 = $db->prepare("SELECT wachtwoord_token FROM Gebruikers WHERE id = ? LIMIT 1");
	$sql3->bind_param("s", $id) ;
	$sql3->bind_result($token_db);
	$sql3->execute();
	$sql3->fetch();

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

		//Random getal voor salt genereren
		$saltbytes = openssl_random_pseudo_bytes(32);
		$salt = bin2hex($saltbytes);

		//Hashen met SHA-256
		$wwhash = hash('sha256', $wachtwoord);
		$saltedwwhash = hash('sha256', $salt . $wwhash);

		//Combinatie salt en wachtwoordhash voor database
		$saltww = $salt . $saltedwwhash;

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
	  
	} else {
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


