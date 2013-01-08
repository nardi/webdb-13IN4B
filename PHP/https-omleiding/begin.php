<?php
if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS'] ) {   //alternatief: $_SERVER['SERVER_PORT']==80
	die('FOUT: Roep dit script op via HTTPS://') ;
}
?>
<html>
<head>
	<title>Begin van een PHP-pagina</title>
<style type="text/css">
	body { font-family: Arial; }
	h1 {font-size: 24; }
</style>
</head>

<body>

<h1>Deze pagina bevat PHP-tags.</h1>

<?php
// Hier kan een php-script komen. Dit is een commentaar-regel.
// De tag met ?php geeft het begin aan
// en die hierna is het eind.
?>

<p>Dit is weer vaste tekst.</p>

</body>

</html>