<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<head>
<script>
function vraag_selectie()
{
var mylist=document.getElementById("myList");
document.getElementById("keuze_1").value=mylist.options[mylist.selectedIndex].text;
}

function tweede_vraag_selectie()
{
var mylist=document.getElementById("myList");
document.getElementById("keuze_2").value=mylist.options[mylist.selectedIndex].text;
}

function derde_vraag_selectie()
{
var mylist=document.getElementById("myList");
document.getElementById("keuze_3").value=mylist.options[mylist.selectedIndex].text;
}
</script>
</head>

<body>

<?php
	if ((!isset($_SESSION['logged-in']))) {
		?>
		<pre>
		U bent niet ingelogd!
		</pre>
		<?php
	} else {
		?>
		<form>
		Waar gaat uw vraag over?
		<select id="myList" onchange="vraag_selectie()">
		<option></option>
		<option>Factuur</option>
		<option>Verzending</option>  
		<option>Artikel</option>
		<option>Klacht</option>
		</select>
		
		var x = <input type="text" id="keuze_1" size="20"></p> ;
		switch (x)
		{
		case Factuur:
			document.write("<p>Als u naar "Mijn Account" gaat dan kunt u uw facturen van de bestellingen bekijken.</p>");
			break;
		case Verzending:
			<form>
			Welke specifieke vraag heeft u over de verzending?
			<select id="myList" onchange="tweede_vraag_selectie()">
			<option></option>
			<option>Verzendkosten</option>
			<option>Verzend-duur</option> 
			
			var y =	<input type="text" id="keuze_2" size="20"> ;
			switch (y)
			{
			case Verzendkosten:
				document.write("<p>Onze standaard verzendkostenbedragen €6,75. Deze worden berekend aan het eindvan het bestelproces.</p>");
				break;
			
			case Verzend-duur:
				document.write("<p>Als op werkdagen voor 19:00 bij ons besteld heeft, dan wordt de volgende dag uw bestelling afgeleverd door PostNL</p>");
				break;
			}
		case Artikel:
		
			<form>
			U heeft een vraag over een artikel, specificeer uw vraag gelieve verder:
			<select id="myList" onchange="derde_vraag_selectie()">
			<option></option>
			<option>Releasedatum bepaald artikel</option>
			<option>Heeft u een bepaald artikelop voorraad?</option>  
			</select>
			var z =	<input type="text" id="keuze_3" size="20"> ;
			switch (z) 
			{
			case Releasedatum bepaald artikel:
				document.write("<p>Alle artikelen die binnen 30 dagen in onze webshop zullen verschijnen kunt u vinden onder het kopje "Nieuwe Releases".</p>");
				break;
			case Heeft u een bepaald artikel op voorraad?:
				document.write("<p>Als u op het artikel klikt dan kunt u in het overzicht zien als een artikel niet op voorraad is.</p>");
				break;
			}
		case Klacht:
				document.write"<p>Klik op <a href='klachtenformulier.php'>deze link</a> om bij het klachtenformulier te komen.</p>");
				break;
		} <?php
		}
		?>
		</form>
		</body>

		</html>

