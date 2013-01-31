<!--
Klant komt op deze pagina terecht als als hij een vraag over de factuur heeft.
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
	
	<!--
	Dit formulier gebruikt de loadXMLDoc functie om nieuwe paginas in onderstaande div te laden waardoor
	structuur van vragen en antwoorden op de site zichtbaar worden.
	De functie is gedefinieerd in klantenservice.js
	-->
	<form>
	Wat voor vraag heeft u over uw factuur? <br />
	<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value,'choice_factuur')">
	<option value="">Kies een onderwerp...</option>
	<option value="backend/klantenservice_factuur_klopt_niet.php">Factuurbedrag klopt niet</option>
	<option value="backend/klantenservice_factuur_niet_ontvangen.php">Ik heb geen factuur ontvangen</option>  
	<option value="backend/klantenservice_overige.php">Overige factuurvragen</option>
	</select>
	</form>
	
	<!--
	In deze div word de volgende pagina geladen.
	-->
	<div id="choice_factuur">
		
	</div>
	</div>
	</div>	

<?php
}
?>
	
	