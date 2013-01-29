<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">


<script src="klantenservice.js">
</script>

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
	<div class="centered-container"> 
		<div class="account-wachtwoord-veranderen">
		<hr width="100%">
		<br />
		
		<form>
		Wat voor vraag heeft u over de verzending? <br />
		<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value,'choice_verzending')">
		<option value="">Kies een onderwerp...</option>
		<option value="backend/klantenservice_verzending_wanneer.php">Wanneer wordt bestelling verzonden?</option>
		<option value="backend/klantenservice_verzendkosten.php">Wat zijn de verzendkosten?</option>  
		<option value="klantenservice_overige.php">Overige verzendvragen</option>
		</select>
		</form>
		
		<div id="choice_verzending">
		
		
		</div>
		</div>
	</div>	
		</body>
	<?php
	}
	?>
	
	