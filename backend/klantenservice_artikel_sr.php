<!--
Klant komt op deze pagina terecht als hij wil weten waar hij de system-requirement wil weten
-->

<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

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

	<p> Als u de system-requirements van een PC-spel wilt weten, dan kunt u deze vinden in het artikeloverzicht.</p>
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
<?php
}
?>

