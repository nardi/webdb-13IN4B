<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<script src="klantenservice.js">
</script>

<?php
if (!isset($_SESSION['logged-in'])) {
	?>
	<pre>
	U bent niet ingelogd!
	</pre>
	<?php
} else {
	?>
	<div class="centered-container"> 
	<div class="account-wachtwoord-veranderen">
	<h1><b>Klantenservice</b></h1>
	<hr width="100%">
	
	<br />
	
	<form>
	Waar gaat uw vraag over? <br />
	<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value,'choice')">
	<option value="">Kies een onderwerp...</option>
	<option value="backend/klantenservice_factuur.php">Factuur</option>
	<option value="backend/klantenservice_verzending.php">Verzending</option>  
	<option value="backend/klantenservice_artikel.php">Artikel</option>
	<option value="backend/klachtenformulier.php">Klacht</option>
	</select>
	</form>
		
	<div id="choice">
		
	</div>
	</div>
	</div>
			
<?php
}
?>