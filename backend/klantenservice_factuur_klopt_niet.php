<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">


<script src="klantenservice.js">
</script>
</head>


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
	<div class="centered-container"> 
		<div class="account-wachtwoord-veranderen">
		
		<hr width="100%">
		
		<p> Het kan voorkomen dat er iets niet klopt op de factuur. 
		Wij doen altijd onze best om de prijzen up-to-date te houden. 
		Houd er wel rekening mee dat wij standaard altijd €6,75 verzendkosten in rekening brengen. </p>
		
		<form action="../">
		Is hiermee uw vraag beantwoord?<br />
		<select onchange="window.open(this.options[this.selectedIndex].value,'_top')">
		
		<option value="">kies een antwoord...</option>
		<option value="backend/klantenservice_vraag_beantwoord.php">ja</option>
		<option value="backend/klantenservice_niet_beantwoord.php">nee</option>  
		</select>
		</form>
		
		
		
		
		
		</div>
	</div>
		</body>
	<?php
	}
	?>
	
	