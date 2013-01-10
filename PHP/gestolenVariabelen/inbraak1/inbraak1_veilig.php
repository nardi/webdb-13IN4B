<?php
session_start() ;
error_reporting(E_ALL ^ E_NOTICE) ;
print '<?xml version="1.0"?>' ; 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Gestolen variabelen</title>
</head>
<body>

<?php
//Nu is het goed...
$authorized = false;
if ($_SESSION['loggedin']==true && $_SESSION['group']=='admin') {
	$authorized = true;
} 
//en even verderop:
if ($authorized) {
	print 'Hele gevoelige informatie.' ;
}
else {
	print 'Geen toegang /Access denied.' ;
}
?>

</body>
</html>