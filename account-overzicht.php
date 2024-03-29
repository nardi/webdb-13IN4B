<!--
    Op deze pagina kan de gebruiker zijn of haar account bekijken. De gebruiker moet wel ingelogd zijn.
    Vervolgens kan de gebruiker enkele bewerkingen doen op zijn of haar gegevens. 
-->

<div class="centered-container">
<?php
	if ((!isset($_SESSION['logged-in']))) {
	?>
	<p>
U bent niet ingelogd!
	</p>
	<?php
	}
	else {
        
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT naam, achternaam, telefoonnummer, email FROM Gebruikers WHERE id= '".$_SESSION['gebruiker-id']."' LIMIT 1");
        $sql->execute();  
        $sql->bind_result($naam, $achternaam, $telefoonnummer, $email);
        
        if (!$sql->fetch()) { 
            throw new Exception("Onverwachte fout: geen data. Neem contact op met de site-beheerder");
        }
        $sql->free_result();

        $sql = $db->prepare("SELECT postcode, huisnummer, toevoeging, plaats, straat FROM Adressen JOIN AdresGebruiker ON Adressen.id = adres_id WHERE gebruiker_id= '".$_SESSION['gebruiker-id']."' LIMIT 1");
        $sql->execute();  
        $sql->bind_result($postcode, $huisnummer, $toevoeging, $plaats, $straat); 
        
        if (!$sql->fetch()) { 
            throw new Exception("Onverwachte fout: geen data. Neem contact op met de site-beheerder");
        }
        $sql->free_result();
        
        $db->close();
    ?>
    <div class="account-overzicht"> 
      <h1><b>Mijn account</b></h1>
        <hr width="100%">
        <div align="right">
            Voornaam: <input type="text" name="voornaam" disabled value = "<?php echo $naam; ?>"  /><br/>
            Achternaam: <input type="text" name="achternaam" disabled value = "<?php echo $achternaam; ?>" /><br/>
            Postcode: <input type="text" name="postcode" disabled value = "<?php echo $postcode; ?>" /><br/>
            <div class="huisnummer"> 
                Huisnummer:  <input type="text" name="huisnummer" disabled="disabled" value = "<?php echo $huisnummer; ?>" /> 
                <input type="text" name="toevoeging" disabled="disabled" value = "<?php echo $toevoeging; ?>" />
            </div><br/>
            Plaats: <input type="text" name="plaats" disabled value = "<?php echo $plaats; ?>" /><br/>
            Telefoonnummer: <input type="text" name="telefoonnummer" disabled value = "<?php echo $telefoonnummer; ?>" /><br/>
            E-mailadres: <input type="email" name="e-mailadres" disabled value = "<?php echo $email; ?>" /><br/>
        </div>
        <hr width="100%">
        <b>Bestellingen</b><br/>
            <a href="bestelgeschiedenis.php"><input type="submit" value="Bestelgeschiedenis" /></a>
        <hr width="100%">
        <b>Bewerken</b><br/>
            <a href="account-wachtwoord-veranderen.php"><input type="submit"  value="Wachtwoord veranderen" /></a><br/>
            <a href="adres-toevoegen.html"><input type="submit"  value="Adres toevoegen" /></a><br />
            <a href="account-bewerken.php"><input type="submit"  value="Accountgegevens veranderen" /></a><br/>
            <a href="account-verwijderen.html"><input type="submit"  value="Account verwijderen" /></a>
        <hr width="100%">
    </div>

	<?php
		}
	?>
</div>
