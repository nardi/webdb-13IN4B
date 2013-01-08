<?php
	$mysqli = new mysqli('websec.science.uva.nl', 'stdwebp39', 'vipj_0uV', 'stdwebp39') ;
	//alle variabelen die van de gebruiker komen escapen voor ze de database in gaan
	$sql= 'UPDATE injectietest SET password=? WHERE password=? AND username=?' ;
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param(
        'sss', $_POST['newpassword'], $_POST['password'], $_POST['username']
        ); 
	$rs = $stmt->execute() ;
	if (! $rs){
		 //Debug informatie! Uitcommenteren, of naar ´t log sturen
		 echo 'Mysql fout: '.mysql_error().', in query: '.$sql ;
	}
	$melding = ($stmt->affected_rows > 0) ?
		('Het wachtwoord is gewijzigd.') :
		('Fout: onjuiste gebruikersnaam of (oud) wachtwoord.') ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Wachtwoord wijzigen - resultaat</title>
</head>
<body>
	<?php echo $melding ; ?>
</body>
</html>