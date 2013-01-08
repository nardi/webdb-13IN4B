<?php print '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Author" content="Wolter Kaper" />
	<title>CSS-frames pagina!</title>
<style type="text/css">
div.topwindow {
	overflow : hidden;
	background : Aqua;
}
div.mainwindow {
	overflow : auto;
	height : 400px;
	background : Fuchsia;
}
body {
	overflow : hidden;
}
</style>
</head>

<body>
<div class="topwindow">
		 Probeer deze: &nbsp;
		 <a href="CSS-php-frames.php?pag=jantje.txt">Hyperlink 1</a> &nbsp;
		 <a href="CSS-php-frames.php?pag=pietje.txt">Hyperlink 2</a> &nbsp;
		 <a href="CSS-php-frames.zip">Download code</a>
</div>

<div class="mainwindow">
		 <?php
		 $pag = (isset($_GET['pag'])) ? ($_GET['pag']) : ('') ; //read URL-pag parameter in 
		 if (
			$pag=='pagina0.txt' ||
			$pag=='jantje.txt'  ||
			$pag=='pietje.txt'
		 ){
			//a legal file is requested, serve it up
		 	include($pag) ; //fetch the file and replace '<?php ... by its contents
		 }
		 else {
			//an illegal file is requested; serve an innocent default instead
			include('pagina0.txt');
		 }
		 ?>
</div>

</body>
</html>
