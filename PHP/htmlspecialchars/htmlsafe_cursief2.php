<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- (C) Steven Klein, 2005, overgenomen door Wolter Kaper met permissie //-->
<head>
	<title>HTMLspecialchars ja, en toch cursief</title>
	<style type="text/css">
		em { font-style : italic; }
		strong {font-weight: bold }
		span.u {text-decoration: underline }
	</style>
</head>
<body>

<div>
	<?php
	$mijntekst = isset($_POST['mijntekst']) ?
        htmlspecialchars($_POST['mijntekst']) : ('') ;
	//Voor [i]..[/i], [b]..[/b], [u]..[/u] 3x Perl regular expression vervangen...
	$mijnoudetekst = '';
	while($mijntekst != $mijnoudetekst){
		$mijnoudetekst = $mijntekst;
		$mijntekst = preg_replace('/\[i\]((.(?!i\]|\/i\]|b\]|\/b\]|u\]|\/u\]|em\>|\/em\>))*)\[\/i\]/', '<em>$1</em>', $mijntekst) ;
		$mijntekst = preg_replace('/\[b\]((.(?!i\]|\/i\]|b\]|\/b\]|u\]|\/u\]|strong\>|\/strong\>))*)\[\/b\]/', '<strong>$1</strong>', $mijntekst) ;
		$mijntekst = preg_replace('/\[u\]((.(?!i\]|\/i\]|b\]|\/b\]|u\]|\/u\]|span class="u"\>|\/span\>))*)\[\/u\]/', '<span class="u">$1</span>', $mijntekst) ;
	}
	print $mijntekst ; 
	?>
</div>

</body>
</html>