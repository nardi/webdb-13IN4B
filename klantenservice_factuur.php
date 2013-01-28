<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<?php
	if ((!isset($_SESSION['logged-in']))) {
	?>
	<pre>
U bent niet ingelogd!
	</pre>
	<?php
	} else {
	?>
	<div class="account-wachtwoord-veranderen">
		<div align="right"> 
		<h1><center><b>Klantenservice</b></center></h1>
		<hr width="100%">
		<center><b>Vragen over uw factuur</b></center>
		<br />
		
		</div>