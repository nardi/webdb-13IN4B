<?php
if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS'] ) {   
	$uri = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'] ;
	header('Location: '.$uri) ;
}
?>
<!-- XML-declaratie lukt niet als php.ini "short tags" toestaat! //-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 TRANSITIONAL//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<title>Rente op een vast bedrag</title>
<style type="text/css">
	body { font-family: Arial; }
	h1 {font-size: 24; }
</style>
</head>

<body>

	<h1>Rente op een vast bedrag, uitgezet tegen vaste rente</h1>

	<p>Typ de gevraagde gegevens in het formulier, hieronder.</p>

	<form name="form1" method="GET" action="begin.php">
	<table><tr>
		<td>Inleg (gulden): </td>
		<td><input type="text" name="inleg"></td>
	</tr>
	<tr>
		<td>Rente (%): </td>
		<td><input type="text" name="rente"></td>
	</tr>
	<tr>
		<td>Jaren (heel getal): </td>
		<td><input type="text" name="jaren"></td>
	</tr>
	</table>
	<p><input type="submit">&nbsp;<input type="reset"></p>
	</form>
	
</body>

</html>