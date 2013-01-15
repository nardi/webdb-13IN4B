
<!--
<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
    
<div class="centered-container">
    <div class="inlogformulier">
		Hoi
		<div ALIGN="right"> 
			
			<form action='gebruikers-login.php' method='post'>
				<h1><CENTER><b>Inloggen</b></CENTER></h1>
				<hr width='100%'>
				<br>
				<div ALIGN='center'>
				Vul hieronder uw inloggegevens in.
				</div><br>
				E-mailadres: <input type='text' name='e-mailadres'><br>
				Wachtwoord: <input type='password' name='wachtwoord'><br>
				<input type='submit' value='Log in'><br>";
			</form>
			<a href="http://sisv2.tk/index.php?pag=Wachtwoordvergeten.html"><SMALL> Uw wachtwoord vergeten? </SMALL></a>
		</div>
    </div>
</div>
-->
<?php
	echo "voor session";
	//session_start();
	echo "achter session";
	if (isset($_SESSION['logged-in'])) {
		//echo "Al ingelogd, $_SESSION['gebruiker-id']";
		echo "Hai";
	}
	
	else {
		echo "Hoi, newb";
	}
?>
