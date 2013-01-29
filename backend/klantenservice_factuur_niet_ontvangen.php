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
		
		<p> U heeft aangegeven dat uw geen factuur heeft ontvangen.
		Wij sturen u altijd een orderbevestiging waarin de factuur weergegeven wordt. 
		Het kan zijn dat de orderbevestiging in uw spamfolder terecht is gekomen.
		Controleer alstublieft even uw spamfolder.
		Tevens sturen wij nogmaals dezelfde factuur met de bestelling mee. </p>
		<br /><br />
		
		<form action="../">
		Is hiermee uw vraag beantwoord?<br />
		<select onchange="window.open(this.options[this.selectedIndex].value,'_top')">
		
		<option value="">kies een antwoord...</option>
		<option value="klantenservice_vraag_beantwoord.php">ja</option>
		<option value="klantenservice_niet_beantwoord.php">nee</option>  
		</select>
		</form>
		
		
		
		
		
		</div>
	</div>
		</body>
	<?php
	}
	?>
	
	