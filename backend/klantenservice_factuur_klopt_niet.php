<!--
Klantkomthierterecht als hij in het klantenservicemenu aangeeft dat zijn factuur niet klopt.
-->
<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

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
	Houd er wel rekening mee dat wij standaard €6,75 verzendkosten in rekening brengen. </p>
	<br /><br />
	
	<!--
	Dir formulier controleert of de vraag is beantwoord. bij de 2 keuzes wordt wordt er onchange een nieuwe pagina geopend. 
	-->
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
<?php
}
?>