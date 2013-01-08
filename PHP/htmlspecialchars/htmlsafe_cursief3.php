
<?php
session_start() ;
error_reporting(E_ALL ^ E_NOTICE);
function isFout($tekst) {
	//Deze functie controleert 3 soorten "elementen" [i]...[/i], [b]...[/b], [u]...[/u]
	//Ieder element moet even later worden afgesloten
	//Je mag verschillende soorten elementen onderling nesten
	//Je mag gelijke soorten elementen niet nesten
	//Elementen mogen niet overlappen
	//Retourneert foutmelding (of lege string als alles goed)
	//
	//stap 1: bouw een array met informatie over alle tags
	$alltags = array() ;
	findall('i', $tekst, $alltags) ;
	findall('b', $tekst, $alltags) ;
	findall('u', $tekst, $alltags) ;
	ksort($alltags) ; //sorteer het array op keys (positienummers)
	//print 'alltags:'; print_r($alltags) ;   //debug
	//
	//stap 2: doorloop het array en test elke tag
	//hierbij gebruiken we een stapel die de open elementen representeert
	$openelts = array() ;
	$fout = '' ;  //ga uit van geen foutmelding
	foreach ($alltags As $pos => $tag) {
		if ($tag['se']=='start') {
			//check of dit element-type al eerder geopend is
			if (in_array($tag['type'], $openelts) ) {
				$fout = '['.$tag['type'].'] op positie '.$pos.' is genest binnen een '.
					'['.$tag['type'].']..[/'.$tag['type'].']' ;
			}
			else {
				//het element mag geopend worden
				$openelts[] = $tag['type'] ;
			}
		}
		if ($tag['se']=='end') {
			//check of dit element klaar is om gesloten te worden
			//(alle geneste elementen moeten intussen gesloten zijn)
			if ( $openelts[count($openelts)-1] != $tag['type'] ) {
				$fout = '[/'.$tag['type'].'] eindtag op positie '.$pos.' is onverwacht.' ;
			}
			else {
				//het element mag gesloten worden:
				//haal het hoogste element van de stapel
				array_pop($openelts) ;
			}
		}
		if ($fout) break ;
	}
	if (! $fout) {
		//test nu of alle geopende tags inmiddels zijn gesloten
		if (count($openelts)>0) {
			$fout = 'Er zijn aan het eind '.count($openelts).' elementen niet afgesloten.' ;
		}
	}
	return $fout ; //retourneer melding of lege string
}
function findall($type, $tekst, &$tagsArr) {
	//zoek posities van begin en eindtags van $type in $tekst
	//en voeg deze toe aan $tagsArr
	//posities als keys, $type en start/end als waarden
	$pos = -1 ;
	//om een teken op $pos=0 te kunnen vinden is de test !==false nodig (type boolean moet ook getest)
	while ( ($pos=strpos($tekst,'['.$type.']',$pos+1))!==false ) {
		$tagsArr[$pos]['type'] = $type ;
		$tagsArr[$pos]['se'] = 'start' ;
	}
	while ( ($pos = strpos($tekst, '[/'.$type.']', $pos+1))!==false ) {
		$tagsArr[$pos]['type'] = $type ;
		$tagsArr[$pos]['se'] = 'end' ;
	}
}
//main script starts
if ($_SESSION['fout'] || ! $_POST['mijntekst']) {
    print '<?xml version="1.0"?>' ;
	?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>HTMLspecialchars ja, en toch cursief</title>
		<style type="text/css">
			em { font-style : italic; }
			strong {font-weight: bold }
			span.u {text-decoration: underline }
			.error { color: Red }
		</style>
	</head>
	<body>
	<form method="POST" action="htmlsafe_cursief3.php">
	    <?php
		if ($_SESSION['fout']) { print '<p class="error">Fout: '.$_SESSION['fout'].'</p>' ;}?>
		<p>Typ hier een tekst:<br />
			<textarea name="mijntekst" rows="5" cols="60"><?php print $_SESSION['mijntekst'] ; ?></textarea>
		</p>
		<?php $_SESSION['fout']='' ; $_SESSION['mijntekst']='' ; ?>
		<ul>
			<li>Tekens die in html een speciale betekenis hebben, zoals &lt;, &gt; en &amp;
			worden gecodeerd. Hierdoor zijn deze als gewone tekens te gebruiken.</li>
			<li>Typ [i]tekst[/i] voor cursieve <em>tekst</em>,</li>
			<li>Typ [b]tekst[/b] voor vette <strong>tekst</strong>,</li>
			<li>Typ [u]tekst[/u] voor onderstreepte <span class="u">tekst</span>.</li>
			<li>Iedere [i],[b] of [u] moet afgesloten met [/i], [/b], [/u]</li>
			<li>Overlap, bijv. [i]cursief [b]cursief en vet[/i] vet[/b] mag niet</li>
			<li>Nesten, bijv. [i]cursief [b]cursief en vet[/b] cursief[/i] mag wel, maar niet [i] binnen een [i]..[/i], etc...</li>
		</ul>
		<p>Alles wordt gecontroleerd!</p>
		<input type="submit" />
	</form>
	</body>
	</html>
	<?php
}
else {
	$mntekst = htmlspecialchars($_POST['mijntekst']) ;
	$_SESSION['mijntekst']=$_POST['mijntekst'] ;
	$_SESSION['fout']=isFout($mntekst) ;
	if (! $_SESSION['fout']) {
		$mntekst = str_replace('[i]', '<em>', $mntekst) ;
		$mntekst = str_replace('[/i]', '</em>', $mntekst) ;
		$mntekst = str_replace('[b]', '<strong>', $mntekst) ;
		$mntekst = str_replace('[/b]', '</strong>', $mntekst) ;
		$mntekst = str_replace('[u]', '<span class="u">', $mntekst) ;
		$mntekst = str_replace('[/u]', '</span>', $mntekst) ;
		//we printen nu de tekst in een net document
		?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
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
				<?php print $mntekst ; ?>
			</div>
		</body>
		</html>
		<?php
	}
	else {
		//Er is een fout: roep het formulier opnieuw op, met de foutmelding
		header('Location: '.$_SERVER['PHP_SELF']) ;
	}
}
?>
