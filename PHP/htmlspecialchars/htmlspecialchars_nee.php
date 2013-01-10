<?php 
session_start(); //start een sessie om het stelen van de sessie-cookie te demonstreren
?>  
<?php print '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>HTMLspecialchars neen</title>
</head>
<body>

<div><?php print $_POST['mijntekst'] ?></div>

</body>
</html>