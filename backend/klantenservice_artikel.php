<!--
Dit is een doorlinkpagina van klantenservice.php werkt exact hetzelfde.
-->
<script src="klantenservice.js">
</script>

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
	Wat voor vraag heeft u over een artikel? <br />
	<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value,'choice_artikel')">
	<option value="">Kies een onderwerp...</option>
	<option value="backend/klantenservice_artikel_voorraad.php">Factuurbedrag klopt niet</option>
	<option value="backend/klantenservice_artikel_sr.php">Wat zijn de system-requirements voor dit artikel?</option>  
	<option value="backend/klantenservice_overige.php">Overige artikelvragen</option>
	</select>
	</form>
	
	<div id="choice_artikel">
	</div>
	</div>
	</div>	
<?php
}
?>
	
	