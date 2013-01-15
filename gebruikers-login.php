<?php
	session_start();
	
    require 'main.php';

    $db = connect_to_db();
	
	$emailadres = $_POST['e-mailadres'];
    $wachtwoord = $_POST['wachtwoord'];
	
	$sql = $db->prepare("SELECT id, wachtwoord, naam FROM Gebruikers WHERE email = ? LIMIT 1");
	$sql->bind_param("s", $emailadres);
	$sql->execute();
	$sql->bind_result($id, $wwdb, $naam);

	if (! $sql->fetch()) {print "Onverwachte fout: Geen data."; exit(); }
	$sql->free_result();
	$db->close();
	
	
	$wwhash = hash('sha256', $wachtwoord);
	$salthash = str_split($wwdb, 64);
	$salt = $salthash[0];
	$saltedwwhash = hash('sha256', $salt . $wwhash);
	
	if($saltedwwhash == $salthash[1]) {
		$_SESSION['logged-in'] = 1;
		$_SESSION['gebruiker-id'] = $id;
		$_SESSION['gebruiker-naam'] = $naam;
		echo "Welkom terug, ".$_SESSION['gebruiker-naam'];
		?>
		
		<script type="text/JavaScript">
			setTimeout("location.href = 'http://superinternetshop.nl/';",2000);
		</script>
		
		<?php
	}
	else {
		echo "Fail";
	}
	
?>
	
	
	