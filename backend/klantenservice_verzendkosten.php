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

	<p>Onze standaard verzendkosten bedragen €6,75 per bestelling.</P>
	</div>
	</div>	
	
	<?php
}
?>
	
	
	