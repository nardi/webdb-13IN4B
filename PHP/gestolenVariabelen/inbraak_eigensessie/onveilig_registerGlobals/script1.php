<?php 
session_start() ;
//N.B.: gebruik van session_register is tegenwoordig afgeraden
session_register('z') ;
//N.B.: gebruik van $x, $y en $z alsof het gewone variabelen zijn is afgeraden
if ($x='123' && $y='456') {
	 $z = 'goedgekeurd' ;
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
