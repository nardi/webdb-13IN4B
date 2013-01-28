<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<head>
<script>

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
		<form action=../">
		Waar gaat uw vraag over?
		<select id="myList" onchange="window.open(this.options[this.selectedIndex].value,'_top')">
		<option value="">Kies een onderwerp...</option>
		<option value="klantenservice_factuur.php">Factuur</option>
		<option>Verzending</option>  
		<option>Artikel</option>
		<option>Klacht</option>
		</select>
		</form>
		
		
		
		
		<?php
		
		?>
		</form>
		</body>

		</html>

