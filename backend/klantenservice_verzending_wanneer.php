<!--
Klant komt op deze pagina terecht als hij informatie wil over wanneer verzending plaatsvind.
-->

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

	<p>Alle bestellingen die op werkdagen voor 21:00 zijn gedaan worden de volgende dag bij u afgeleverd</P>
	
	<!--
	Dit is het einde van de dropdownbox en nieuwe paginas worden niet onder de andere geladen.
	Met de window.open methode wordt de klant doorgezet naar een nieuwe pagina.
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
	
	
	