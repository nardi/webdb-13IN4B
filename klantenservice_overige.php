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
	
	<?php
	echo "U heeft aangegevendat uw vraag er niet tussen staat.
		u gaat nu automatisch door naar het klantenserviceformulier.";
		
	?>
	<script type="text/JavaScript">
	   setTimeout("location.href = '/klantenservice_niet_beantwoord.php';",3500);
	</script>
	
	</div>
	</div>
	<?php
}