<?php
	$mysqli = new mysqli('websec.science.uva.nl', 'stdwebp39', 'vipj_0uV', 'stdwebp39') ;
	$sql = 'SELECT username FROM injectietest '.
	   'WHERE username="'.$_POST['username'].'" AND password="'.$_POST['password'].'"' ;
	$stmt = $mysqli->prepare($sql);
	$rs = $stmt->execute() ;
	if (! $rs){
		 echo 'Mysql fout: '.$stmt->error.' gemaakt door sql: '.$sql ;
	}
	if ($stmt->fetch()) {

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Geheime inhoud</title>
</head>
<body>
	<?php echo 'Gefeliciteerd, u bent doorgedrongen in het geheime domein van X.' ;?>
</body>
</html>

<?php } 
else echo 'Inloggen is mislukt. Debug info: het SQL commando was: '.$sql ; 
?>
