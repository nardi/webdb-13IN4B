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
        <br>
        Voornaam: <input type="text" name="voornaam" disabled="disabled" value = "<?php echo $naam; ?>" ><div id="voornaam-label" class="label-div"></div>
        Achternaam: <input type="text" name="achternaam" disabled="disabled" value = "<?php echo $achternaam; ?>"><div id="achternaam-label" class="label-div"></div>
        Postcode: <input type="text" name="postcode" disabled="disabled" value = "<?php echo $postcode; ?>"><div id="postcode-label" class="label-div"></div>
        Huisnummer en toevoeging:
        <div class="huisnummer"> 
          <input type="tekst" id="huisnummer" name="huisnummer" value = "<?php echo $huisnummer; ?>"> <input type="tekst" name="toevoeging" value = "<?php echo $toevoeging; ?>"><div id="huisnummer-label" class="label-div"></div>
        </div>
        Straat: <input type="text" name="straat" disabled="disabled" value = "<?php echo $straat; ?>"><div id="straat-label" class="label-div"></div>
        Plaats: <input type="text" name="plaats" disabled="disabled" value = "<?php echo $plaats; ?>"><div id="plaats-label" class="label-div"></div>
        Telefoonnummer: <input type="text" name="telefoonnummer" disabled="disabled" value = "<?php echo $telefoonnummer; ?>"><br/>
        E-mailadres: <input type="email" name="e-mailadres" disabled="disabled" value = "<?php echo $email; ?>"><div id="email-label" class="label-div"></div>
        <hr width="100%">
        <center><b>Bestellingen</b></center><br>
        <div align="center"> 
        <a href="bestellingen-geschiedenis.html"><input type="submit"  value="Bestelgeschiedenis"></a>
        </div>
        <hr width="100%">
        <center><b>Bewerken</b></center><br>
        <div align="center"> 
        <a href="account-wachtwoord-veranderen.html"><input type="submit"  value="Wachtwoord veranderen"></a><br>
        <a href="account-bewerken.html"><input type="submit"  value="Accountgegevens veranderen"></a>
        </div>
        <hr width="100%">
      </div>
    </div>

	<?php
		}
	?>