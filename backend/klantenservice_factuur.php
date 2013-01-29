<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<head>
<script src="klantenservice.js"></script>
</head>
<body>

<?php
	session_start();
	if ((!isset($_SESSION['logged-in']))) {
	?>
	<pre>
U bent niet ingelogd!
	</pre>
	<?php
	} else {
	?>
	<div class="account-wachtwoord-veranderen">
		<div align="right"> 
		<hr width="100%">
		
		
		<form>
		Wat voor vraag heeft u over uw factuur?
		<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value)">
		<option value="">Kies een onderwerp...</option>
		<option value="backend/klantenservice_factuur_klopt_niet.php">Factuurbedrag klopt niet</option>
		<option value="backend/klantenservice_factuur_niet_ontvangen.php">Ik heb geen factuur ontvangen</option>  
		<option value="backend/klantenservice_factuur_overige.php">Overige factuurvragen</option>
		</select>
		</form>
		
		<div id="choice">
		
		
		</div>
		</div>
		
		</body>
	<?php
	}
	?>
	
	