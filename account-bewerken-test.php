<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
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
        <form name="regform" id="regformid"  onsubmit="submitThisShit()" action="javascript: void(0)" method="post">
          <div align="right"> 
          <h1><center><b>Mijn account</b></center></h1>
              <hr width="100%">
              <center><b>Accountgegevens bewerken</b></center>
              <br/>
              Voornaam: <input type="text" id="voornaam" name="voornaam" onblur="checkNaam('voornaam', 'voornaam-label')" value = "<?php echo $naam; ?>"><div id="voornaam-label" class="label-div"></div><br/>
              Achternaam: <input type="text" id="achternaam" name="achternaam" onblur="checkNaam('achternaam', 'achternaam-label')" value = "<?php echo $achternaam; ?>"><div id="achternaam-label" class="label-div"></div><br/>
              Huisnummer en toevoeging:
              <div class="huisnummer"> 
                <input type="tekst" id="huisnummer" name="huisnummer" onchange="completeAddress()" onblur="checkHuis()" value = "<?php echo $huisnummer; ?>"> <input type="tekst" name="toevoeging" value = "<?php echo $toevoeging; ?>"><div id="huisnummer-label" class="label-div"></div>
              </div><br/>

              Postcode: <input type="text" id="postcode" name="postcode" onblur="checkPostcode()" value = "<?php echo $postcode; ?>"><div id="postcode-label" class="label-div"></div><br/>
              Straat: <input type="text" id="straatid" name="straat" disabled="disabled" value = "<?php echo $straat; ?>"><div id="straat-label" class="label-div"></div><br>
              Plaats: <input type="text" name="plaats" disabled="disabled" value = "<?php echo $plaats; ?>"><div id="plaats-label" class="label-div"></div><br>
        
              Telefoonnummer: 
              <div class="telnr"> 
                <div class="telnr1"> 
                    <input type="tel" name="telefoonnummer" id="tel" onblur="checkTel()" value = "<?php print_r($telnr[0]); ?>"> -
                </div> 
                <div class="telnr2"> 
                    <input type="tel" id="tel2" name="telefoonnummer2" onblur="checkTel()" value = "<?php print_r($telnr[1]); ?>">
                </div>
              </div>  
              <div id="tel-label" class="label-div" class="label-div"></div>
              <hr width="100%">
              <center><b>Inloggegevens</b></center><br/>
              E-mailadres: <input type="text" id="email" name="e-mailadres" onblur="checkMail()" value = "<?php echo $email; ?>"><div id="email-label" class="label-div"></div><br/>
              E-mailadres bevestigen: <input type="text" id="email-bevestigen" name="e-mailadres-conf" onblur="verify('email','email-bevestigen', 'email-bevestigen-label')" value = "<?php echo $email; ?>"><div id="email-bevestigen-label" class="label-div"></div><br/>
              <hr width="100%">
              <p>Voer uw wachtwoord in om de wijzigingen te bevestigen:</p>
              <input type="password" name="wachtwoord">
              <input type="submit" value="Wijzigingen bevestigen"><br/>
              </div>
        </form>
    </div>
</div>
    <?php
    $db = connect_to_db();
      
    $gebruiker_id = $_SESSION['gebruiker-id'];  
    $wachtwoord = $_POST['wachtwoord'];         
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $postcode = $_POST['postcode'];
    $huisnummer = $_POST['huisnummer'];
    $toevoeging = $_POST['toevoeging'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $telefoonnummer2 = $_POST['telefoonnummer2'];
    $telelfoonnummerTot;
    $emailadres = $_POST['e-mailadres'];
    
    $nonStrictPostcode = '/^[0-9]{4}[\s-][a-z]{2}$/i';
    
    if(preg_match($nonStrictPostcode, $postcode)){
        $postcode=substr($postcode,0,4).substr($postcode,5);
    }
    
    $adres_info = json_decode(get_address($postcode, $huisnummer));
    $straat = $adres_info->street;
    $plaats = $adres_info->city;
    
    $validNaam = '/^[a-z]{1,256}$/i';
    $validPostcode = '/^[0-9]{4}[\s-]?[a-z]{2}$/i';
    $validTel1 = '/^[0-9]{2,4}$/';
    $validTel2 = '/^[0-9]{6,8}$/';
    $validTelTot = '/^[0-9]{10}$/';
    $validHuis = '/^[0-9]{1,5}$/';
    $validMail='/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';

    $sqlww = $db->prepare("SELECT wachtwoord FROM Gebruikers WHERE id = ? LIMIT 1");
    $sqlww->bind_param('i', $_SESSION['gebruiker-id']);
    $sqlww->execute();
    $sqlww->bind_result($wwdb);
    $sqlww->fetch();
    $sqlww->free_result();

    if (!check_wachtwoord($wachtwoord, $wwdb)){
        redirect_to("wachtwoord-onjuist.html");
        $db->close();
        exit();
    }
    else {
        if(preg_match($validNaam, $voornaam)&&
           preg_match($validNaam, $achternaam)&&
           preg_match($validPostcode, $postcode)&&
           preg_match($validHuis, $huisnummer)&&
           preg_match($validTel1, $telefoonnummer)&&
           preg_match($validTel2, $telefoonnummer2)&&
           preg_match($validMail, $emailadres)){
            
            $telefoonnummerTot = $telefoonnummer . '-' . $telefoonnummer2;
            
            $sqli_gebruikers = $db->prepare("UPDATE Gebruikers SET naam = ?, achternaam = ?, telefoonnummer = ?, email = ? WHERE id= '".$_SESSION['gebruiker-id']."'");
            
            $sqli_gebruikers->bind_param('ssss',$voornaam, $achternaam, $telefoonnummerTot, $emailadres);

            $sqli_adressen = $db->prepare("UPDATE Adressen JOIN AdresGebruiker ON Adressen.id = adres_id SET postcode = ?, huisnummer = ?, toevoeging = ?, plaats = ?, straat = ? WHERE id= '".$_SESSION['gebruiker-id']."'");
            
            $sqli_adressen->bind_param('sisss',$postcode , $huisnummer , $toevoeging , $plaats , $straat);
            
            if(!$sqli_gebruikers->execute())
                throw new Exception($sqli_gebruikers->error);
            if(!$sqli_adressen->execute())
                throw new Exception($sqli_adressen->error);
            
            redirect_to("wijzigingen-succesvol.html");
            $db->close();
            exit();  
        }
    
        else{
           echo preg_match($validNaam, $voornaam).
           preg_match($validNaam, $achternaam).
           preg_match($validPostcode, $postcode).
           preg_match($validHuis, $huisnummer).
           preg_match($validTel1, $telefoonnummer).
           preg_match($validTel2, $telefoonnummer2).
           preg_match($validMail, $emailadres);
        }
    }
    
  }
?>