<?php
	$mysqli = new mysqli('websec.science.uva.nl', 'stdwebp39', 'vipj_0uV', 'stdwebp39') ;
	//gebruik vraagtekens voor user-input, en doe dan bind_param.
	$sql = 'SELECT username FROM injectietest WHERE username=? AND password=?' ;
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $_POST['username'], $_POST['password']);
	$rs = $stmt->execute() ;
	if (! $rs){
         //debug info -- uitcommentarieren of naar de logfile sturen na debug-fase
		 echo 'Mysql fout: '.$stmt->error.' gemaakt door sql: '.$sql ;
	}
	//Eis dat precies 1 gevonden wordt. Een query die meer dan 1 user oplevert deugt hier zowiezo niet. 
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
<?php 
} 
else {
	//Debug info weggehaald
	echo 'Inloggen is mislukt.' ;
} 
?>