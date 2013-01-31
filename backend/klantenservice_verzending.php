<!--
Klant komt op deze pagina terecht als als hij een vraag over de verzending heeft.
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
	
	<!--
	Dit formulier gebruikt de loadXMLDoc functie om nieuwe paginas in onderstaande div te laden waardoor
	structuur van vragen en antwoorden op de site zichtbaar worden.
	De functie is gedefinieerd in klantenservice.js
	-->	
	<form>
	Wat voor vraag heeft u over de verzending? <br />
	<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value,'choice_verzending')">
	<option value="">Kies een onderwerp...</option>
	<option value="backend/klantenservice_verzending_wanneer.php">Wanneer wordt bestelling verzonden?</option>
	<option value="backend/klantenservice_verzendkosten.php">Wat zijn de verzendkosten?</option>  
	<option value="backend/klantenservice_overige.php">Overige verzendvragen</option>
	</select>
	</form>
	
	<!--
	In deze div word de volgende pagina geladen.
	-->	
	<div id="choice_verzending">
		
	</div>
	</div>
	</div>	
<?php
}
?>
	
	