<?php
session_start() ; 
print '<?xml version="1.0"?>' ; 
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Inbraak in sessievariabelen - script 2</title>
</head>
<body>

<div>
<?php
//Door gebruik van S_SESSION['z'] weten we nu zeker dat dit gegeven niet 
//direct van de gebruiker komt - de getoonde inbraak is verijdeld.
if ($_SESSION['z']=='goedgekeurd') {
	print 'U mag alles zien!';
}
else {
	print 'Geen toegang / Access denied.' ;
}
?>
</div>

</body>
</html>
