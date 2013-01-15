<?php
    require 'main.php';

    $db = connect_to_db();
	
	$emailadres = $_POST['e-mailadres'];
    $wachtwoord = $_POST['wachtwoord'];
	
	$sql = $db->prepare("SELECT Wachtwoord FROM database_registratie WHERE Emailadres = ?");
	$sql->bind_param("s", $emailadres);
	$sql->execute();
	$sql->bind_result($wwdb);
	$db->close();
	
	echo ($wwdb);
	
	
	
	/*
	$wwhash = hash('sha256', $wachtwoord);
	$salthash = str_split($wwdb, 64);
	$salt = $salthash[0];
	$saltedwwhash = hash('sha256', $salt . $wwhash);
	
	if($saltedwwhash == $salthash[1]) {
		echo "Succes";
	}
	else {
		echo "Fail";
	}
	*/
?>
	
	
	