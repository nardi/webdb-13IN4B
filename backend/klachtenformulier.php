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
	<br />
	<?php
	echo "Ondanks dat wij uitermate onze best doen om uw winkelervaring plesant te maken, nemen uw klachten zeer serieus.
		U kunt via onderstaande link uw klacht aan ons kenbaar maken.";
	?>
	<br /><br />
	<a href="/klantenservice_niet_beantwoord.php">dien klacht in</a>
	
	</div>
	</div>
<?php
}
?>