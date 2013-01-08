<?php 
session_start() ;
//Gebruik $_POST als gegevens gepost zijn, $_GET als ze uit de URL komen
if ($_POST['x']=='123' && $_POST['y']=='456') {
	//Gebruik $_SESSION voor sessievars., "session_register" is dan overbodig.
	$_SESSION['z'] = 'goedgekeurd' ;
}
print '<?xml version="1.0"?>'; 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Inbraak in sessievariabelen - script 1</title>
</head>
<body>

<p><a href="script2.php">link naar script 2</a></p>

</body>
</html>
