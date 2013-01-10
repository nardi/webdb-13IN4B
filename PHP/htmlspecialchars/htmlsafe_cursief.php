<?php print '<?xml version="1.0"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>HTMLspecialchars ja, en toch cursief</title>
	<style type="text/css">
		em { font-style : italic; }
	</style>
</head>
<body>

<div>
	<?php
	$mijntekst = htmlspecialchars($_POST['mijntekst']) ;
	//een Perl regular expression wordt vervangen. Uitleg er onder.
	$mijntekst = preg_replace('/\[i\](.*)\[\/i\]/U', '<em>$1</em>', $mijntekst) ;
	//Te matchen string is: '[i](.*)[/i]'
	//Hierin stelt (.*) een groep van 0 of meer willekeurige tekens voor
	//$1 verwijst terug naar de eerste groep, dus naar (.*)
	//Groepen staan tussen (). Je kunt er in je zoekstring meer hebben.
	//In de te matchen string moeten [ en ] en / ge-escaped worden met \
	//Zo kom ik aan: '\[i\](.*)\[\/i\]'
	//Daar moet nog een / vóór en /U achter
	//De U geeft aan dat de * quantifier op een zo klein mogelijk stuk tekst slaat
	//(Als je de U weglaat pakt hij een zo groot mogelijk stuk...
	// m.a.w. in [i]cursief[/i] niet cursief [i]weer cursief[/i}
	// wordt alles tussen de eerste [i] en de laatste [/i] gepakt en dat wil je niet...
	// daarom dus die U.)
	print $mijntekst ; 
	?>
</div>

</body>
</html>
