<?php
	mysql_connect('websec.science.uva.nl', 'stdwebp39', 'vipj_0uV') ;
	mysql_select_db('stdwebp39') ;
	//eerst alle bijzondere tekens escapen, speciaal de aanhalingstekens.
	$username = mysql_real_escape_string($_POST['username']) ;
	$password = mysql_real_escape_string($_POST['password']) ;
	$sql= 'SELECT username FROM injectietest WHERE username="'.$username.'" AND password="'.$password.'"' ;
	$rs = mysql_query($sql) ;
	if (! $rs){
		 //Debug informatie! Uitcommenteren in productieversie
		 echo 'Mysql fout: '.mysql_error().', in query: '.$sql ;
	}
	//Eis dat precies 1 gevonden wordt. Een query die meer dan 1 user oplevert deugt hier zowiezo niet. 
	if (mysql_num_rows($rs)==1) {
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
	//Debug info weghalen voordat script in productie gaat.
	echo 'Inloggen is mislukt. Debug info: het SQL commando was='.$sql ;
} 
?>
