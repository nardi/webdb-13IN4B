<!--
Klant komt op deze pagina terecht als hij een overige vraag heeft. Klant kan dan op een link klikken voor het contactformulier.
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
	<?php
	echo "U heeft aangegeven dat uw vraag er niet tussen staat.
		Klikop onderstaande link om ons een bericht te sturen.";
	?>
	<br /><br />
	<a href="/klantenservice_niet_beantwoord.php">ga naar formulier</a>
	
	</div>
	</div>
<?php
}
?>