<?php
	$mysqli = new mysqli('websec.science.uva.nl', 'stdwebp39', 'vipj_0uV', 'stdwebp39') ;
	$sql= 'UPDATE injectietest SET password="'.$_POST['newpassword'].'" '.
	   'WHERE password="'.$_POST['password'].'" AND username="'.$_POST['username'].'"' ;
	$stmt = $mysqli->prepare($sql);
	$rs = $stmt->execute() ;
	if (! $rs){
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
