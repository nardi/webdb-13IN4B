<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
 
<?php
	if ((!isset($_SESSION['logged-in']))) {
	?>
	<pre>
U bent niet ingelogd!
	</pre>
	<?php
	}
	else {
        
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT naam, achternaam, telefoonnummer, email FROM Gebruikers WHERE id= '".$_SESSION['gebruiker-id']."' LIMIT 1");
        $sql->execute();  
        $sql->bind_result($naam, $achternaam, $telefoonnummer, $email);
        
        if (!$sql->fetch()) { print "Onverwachte fout: Geen data."; exit(); }
        $sql->free_result();

        $sql = $db->prepare("SELECT postcode, huisnummer, toevoeging, plaats, straat FROM Adressen JOIN AdresGebruiker ON Adressen.id = adres_id WHERE gebruiker_id= '".$_SESSION['gebruiker-id']."' LIMIT 1");
        $sql->execute();  
        $sql->bind_result($postcode, $huisnummer, $toevoeging, $plaats, $straat); 
        
        if (!$sql->fetch()) { print "Onverwachte fout: Geen data."; exit(); }
        $sql->free_result();
        
        $db->close();
    ?>
    <div class="account-overzicht">
      <div align="right"> 
      <h1><center><b>Mijn account</b></center></h1>
        <hr width="100%">
        <center><b>Accountgegevens</b></center>
        <br/>
        Voornaam: <input type="text" name="voornaam" disabled value = "<?php echo $naam; ?>" ><br/>
        Achternaam: <input type="text" name="achternaam" disabled value = "<?php echo $achternaam; ?>"><br/>
        Postcode: <input type="text" name="postcode" disabled value = "<?php echo $postcode; ?>"><br/>
        Huisnummer en toevoeging:
        <div class="huisnummer"> 
         Huisnummer:  <input type="tekst" name="huisnummer" disabled="disabled" value = "<?php echo $huisnummer; ?>"> <input type="tekst" name="toevoeging" disabled="disabled" value = "<?php echo $toevoeging; ?>">
        </div>
        Plaats: <input type="text" name="plaats" disabled value = "<?php echo $plaats; ?>"><br/>
        Telefoonnummer: <input type="text" name="telefoonnummer" disabled value = "<?php echo $telefoonnummer; ?>"><br/>
        E-mailadres: <input type="email" name="e-mailadres" disabled value = "<?php echo $email; ?>"><br/>
        <hr width="100%">
        <center><b>Bestellingen</b></center><br/>
        <div align="center"> 
        <a href="bestelgeschiedenis.php"><input type="submit" value="Bestelgeschiedenis"></a>
        </div>
        <hr width="100%">
        <center><b>Bewerken</b></center><br/>
        <div align="center"> 
        <a href="account-wachtwoord-veranderen.php"><input type="submit"  value="Wachtwoord veranderen"></a><br/>
        <a href="account-bewerken.html"><input type="submit"  value="Accountgegevens veranderen"></a><br/>
        <a href="account-verwijderen.html"><input type="submit"  value="Account verwijderen"></a>
        </div>
        <hr width="100%">
      </div>
    </div>

	<?php
		}
	?>