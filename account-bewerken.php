<script src="registratieformulier.js"></script>
<script src="account-bewerken.js"></script>

<?php
	if ((!isset($_SESSION['logged-in']))) {
	?>
	<pre>
        U bent niet ingelogd!
	</pre>
	<?php
	}
	else {
        /*
        De gebruikers gegevens alvast echoen in de text boxes.
        Makkelijker voor de gebruiker.
        */
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

        $telnr = preg_split('/-/', $telefoonnummer, 2, PREG_SPLIT_NO_EMPTY);
?>

<div class="centered-container">
    <div class="registratieformulier">
        <form name="regform" id="regformid"  onsubmit="submitChanges()" action="javascript: void(0)" method="post">
            <div align="right"> 
                <h1><center><b>Mijn account</b></center></h1>
                <hr width="100%">
                <center><b>Accountgegevens bewerken</b></center><br/>
                Voornaam: <input type="text" id="voornaam" name="voornaam" onblur="checkNaam('voornaam', 'voornaam-label')" value = "<?php echo $naam; ?>" /> <div id="voornaam-label" class="label-div"></div><br/>
                Achternaam: <input type="text" id="achternaam" name="achternaam" onblur="checkNaam('achternaam', 'achternaam-label')" value = "<?php echo $achternaam; ?>" /><div id="achternaam-label" class="label-div"></div><br/>
                Huisnummer en toevoeging:
                <div class="huisnummer"> 
                    <input type="tekst" id="huisnummer" name="huisnummer" onchange="completeAddress()" onblur="checkHuis()" value = "<?php echo $huisnummer; ?>" /> <input type="tekst" name="toevoeging" value = "<?php echo $toevoeging; ?>" /><div id="huisnummer-label" class="label-div"></div>
                </div><br/>
                Postcode: <input type="text" id="postcode" name="postcode" onblur="checkPostcode()" value = "<?php echo $postcode; ?>" /><div id="postcode-label" class="label-div" /></div><br/>
                Straat: <input type="text" id="straatid" name="straat" disabled="disabled" value = "<?php echo $straat; ?>" /><div id="straat-label" class="label-div" /></div><br />
                Plaats: <input type="text" name="plaats" disabled="disabled" value = "<?php echo $plaats; ?>" /><div id="plaats-label" class="label-div" /></div><br />
                Telefoonnummer: 
                <div class="telnr"> 
                    <div class="telnr1"> 
                        <input type="tel" name="telefoonnummer" id="tel" onblur="checkTel()" value = "<?php print_r($telnr[0]); ?>" /> -
                    </div> 
                    <div class="telnr2"> 
                        <input type="tel" id="tel2" name="telefoonnummer2" onblur="checkTel()" value = "<?php print_r($telnr[1]); ?>" />
                    </div>
                </div>  
                <div id="tel-label" class="label-div" class="label-div"></div>
                <hr width="100%">
                <center><b>Inloggegevens</b></center><br/>
                E-mailadres: <input type="text" id="email" name="e-mailadres" onblur="checkMail()" value = "<?php echo $email; ?>" /><div id="email-label" class="label-div" /></div><br/>
                E-mailadres bevestigen: <input type="text" id="email-bevestigen" name="e-mailadres-conf" onblur="verify('email','email-bevestigen', 'email-bevestigen-label')" value = "<?php echo $email; ?>" /><div id="email-bevestigen-label" class="label-div"></div><br/>
                <hr width="100%">
                <p>Voer uw wachtwoord in om de wijzigingen te bevestigen:</p>
                <input type="password" name="wachtwoord" />
                <input type="submit" value="Wijzigingen bevestigen" /><br/>
            </div>
        </form>
    </div>
</div>

<?php
    }
?>