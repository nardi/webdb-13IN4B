<!--
    Deze pagina zorgt ervoor dat een gebruiker zijn account kan bewerken. 
    Dat gebeurt met de sql query UPDATE.
    Ten slotte wordt er ook om het wachtwoord gevraagd, dit ter bevestiging.
-->

<?php
    if (!isset($_SESSION['logged-in'])){
        echo 'U moet uiteraard ingelogd zijn om uw account aan te passen.';
        exit();
    }
    
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
?>