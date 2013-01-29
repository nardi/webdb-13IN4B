<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<head>
<head>
<script src="klantenservice.js">
</script>
</head>
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
		<div class="account-wachtwoord-veranderen">
		<div align="right"> 
		<h1><center><b>Klantenservice</b></center></h1>
		<hr width="100%">
		
		<br />
	
		<form>
		Waar gaat uw vraag over? <br />
		<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value,'choice')">
		<option value="">Kies een onderwerp...</option>
		<option value="backend/klantenservice_factuur.php">Factuur</option>
		<option value="klantenservice_verzending.xml">Verzending</option>  
		<option>Artikel</option>
		<option>Klacht</option>
		</select>
		</form>
		
		<div id="choice">
		
		
		</div>
		</div>
		
		</body>
		
		
		<?php
		}
		?>
		
		

		</html>

