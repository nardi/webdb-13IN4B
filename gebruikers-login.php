<?php
    require 'main.php';

	redirect_to("/");
	
    $db = connect_to_db();
	
	$emailadres = $_POST['e-mailadres'];
    $wachtwoord = $_POST['wachtwoord'];
	
	$sql = $db->prepare("SELECT id, wachtwoord, naam, status FROM Gebruikers WHERE email = ? LIMIT 1");
	$sql->bind_param("s", $emailadres);
	$sql->execute();
	$sql->bind_result($id, $wwdb, $naam, $status);

	if (! $sql->fetch()) {print "Onverwachte fout: Geen data."; exit(); }
	$sql->free_result();
	$db->close();
	
	
	$wwhash = hash('sha256', $wachtwoord);
	$salthash = str_split($wwdb, 64);
	$salt = $salthash[0];
	$saltedwwhash = hash('sha256', $salt . $wwhash);
	
	if(empty($saltedwwhash)) {
		echo "Geen wachtwoord ingevuld"
	}
	
	else if($saltedwwhash == $salthash[1]) {
		$_SESSION['logged-in'] = 1;
		$_SESSION['gebruiker-id'] = $id;
		$_SESSION['gebruiker-naam'] = $naam;
		$_SESSION['gebruiker-status'] = $status;
		echo "Welkom terug, ".$_SESSION['gebruiker-naam'];
		flush();
	}
	else {
		echo "Fail";
	}
	
	
	sleep(3);
	
?>
	
	
	