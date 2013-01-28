<?php
	if (isset($_SESSION['logged-in'])) {
        unset($_SESSION['logged-in']);
		unset($_SESSION['gebruiker-id']);
		unset($_SESSION['gebruiker-naam']);
		unset($_SESSION['gebruiker-status']);
		echo "U bent uitgelogd.";		
?>
		<script type="text/JavaScript">
			setTimeout("location.href = '/';",2000);
		</script>
<?php
	} else {
		?>
		<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
			<link rel="stylesheet" type="text/css" href="centering.css">
				
			<div class="centered-container">
				<div class="inlogformulier">
					<div ALIGN="right"> 
					
						<form action="gebruikers-login.php" method="post">
							<h1><CENTER><b>Inloggen</b></CENTER></h1>
							<hr width="100%">
							<br />
							<div ALIGN="center">
							Vul hieronder uw inloggegevens in.
							</div><br />
							E-mailadres: <input type="text" name="e-mailadres"><br />
							Wachtwoord: <input type="password" name="wachtwoord"><br />
							<input type="submit" value="Log in"><br />
						</form>
						
						<a href='wachtwoordvergeten.php'><SMALL> Uw wachtwoord vergeten? </SMALL></a>
					</div>
				</div>
			</div>
	<?php
	}
?>
