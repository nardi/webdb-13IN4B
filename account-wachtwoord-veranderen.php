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
		<h1><center><b>Mijn account</b></center></h1>
		<hr width="100%">
		<center><b>Wachtwoord veranderen</b></center>
		<br />
	
	<?php
		if (!isset($_POST['oud_wachtwoord'])&&
			!isset($_POST['nieuw_wachtwoord'])&&
			!isset($_POST['nieuw_wachtwoord_nogmaals'])) {
			
			echo "<form method='post' action='account-wachtwoord-veranderen.php'>
			Oud wachtwoord: <input type='password' name='oud_wachtwoord'><br />
			Nieuw wachtwoord: <input type='password' name='nieuw_wachtwoord'><br />
			Nieuw wachtwoord bevestigen: <input type='password' name='nieuw_wachtwoord_nogmaals'><br />
			<input type='submit' value='Wachtwoord veranderen'>
			</form>";
			
		} else {
		
			$db = connect_to_db();
			
			$id = $_SESSION['gebruiker-id'] ;
			$wachtwoord = $_POST['oud_wachtwoord'];
			$nieuw_wachtwoord = $_POST['nieuw_wachtwoord'];
			$nieuw_wachtwoord_nogmaals = $_POST['nieuw_wachtwoord_nogmaals'];
			
			$sql = $db->prepare("SELECT wachtwoord FROM Gebruikers WHERE id = ? LIMIT 1");
			$sql->bind_param("s", $id);
			$sql->execute();
			$sql->bind_result($wwdb);
			$sql->fetch();
			sleep(2);
			
			if (check_wachtwoord($wachtwoord, $wwdb)) {
				
				if ($nieuw_wachtwoord === $nieuw_wachtwoord_nogmaals) {
					
					//Random getal voor salt genereren
					$saltbytes = openssl_random_pseudo_bytes(32);
					$salt = bin2hex($saltbytes);

					//Hashen met SHA-256
					$wwhash = hash('sha256', $nieuw_wachtwoord);
					$saltedwwhash = hash('sha256', $salt . $wwhash);

					//Combinatie salt en wachtwoordhash voor database
					$saltww = $salt . $saltedwwhash;

					//Hier wordt het wachtwoord naar de database geschreven
					$db = connect_to_db();
					$sql = $db->prepare("UPDATE Gebruikers SET wachtwoord = '$saltww' WHERE id = ? LIMIT 1");
					$sql->bind_param("s", $id) ;
					$sql->execute();
					echo "Uw wachtwoord is nu aangepast." ;
					
				} else {
					
					echo "U heeft niet 2 maal hetzelfde wachtwoord ingevoerd. Probeer het nogmaals!" ;
					echo "<form method='post' action='account-wachtwoord-veranderen.php'>
					Oud wachtwoord: <input type='password' name='oud_wachtwoord'><br />
					Nieuw wachtwoord: <input type='password' name='nieuw_wachtwoord'><br />
					Nieuw wachtwoord bevestigen: <input type='password' name='nieuw_wachtwoord_nogmaals'><br />
					<input type='submit' value='Wachtwoord veranderen'>
					</form>";
				}
			} else {
				echo "Fout wachtwoord ingevuld. Probeer het opnieuw ";
				
			}
		}
	}
?>	    
  </div>
</div>
</body>

</html>