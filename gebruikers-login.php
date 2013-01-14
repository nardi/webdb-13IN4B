<?php
    require 'main.php';

    $db = connect_to_db();
	$emailadres = $_POST['e-mailadres'];
    $wachtwoord = $_POST['wachtwoord'];
	
	$sql = “SELECT wachtwoord FROM database_registratie WHERE  email = $emailadres”;
	echo $db->query($sql);
	
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
	
	
	