<?php
    require 'main.php';

    $db = connect_to_db();

    $voornaam = $db->escape_string($_POST['voornaam']);
    $achternaam = $db->escape_string($_POST['achternaam']);
    $land = $db->escape_string($_POST['land']);
    $postcode = $db->escape_string($_POST['postcode']);
    $huisnummer = $db->escape_string($_POST['huisnummer']);
    $geboortedatum = $db->escape_string($_POST['jaar'] . '-' . $_POST['maand'] . '-' . $_POST['dag']);
    $telefoonnummer = $db->escape_string($_POST['telefoonnummer']);
    $mobielnummer = $db->escape_string($_POST['mobielnummer']);
    $emailadres = $db->escape_string($_POST['e-mailadres']);
    $wachtwoord = $db->escape_string($_POST['wachtwoord']);
    $created_at = date('Y-m-d');
    
    //Random getal voor salt genereren
    $saltbytes = openssl_random_pseudo_bytes(32);
    $salt = bin2hex($saltbytes);
    
    //Hashen met SHA-256
    $wwhash = hash('sha256', $wachtwoord);
    $saltedwwhash = hash('sha256', $salt . $wwhash);
    
    //Combinatie salt en wachtwoordhash voor database
    $saltww = $salt . $saltedwwhash;
    /*               '.       
        .-""-._     \ \.--|  
       /       "-..__) .-'   
     ?_______?             /     
      \'-.__,   .__.,'       
       `'----'._\--'  
     * Whale whale whale, what have we here?
     *
     */

    $sql = "INSERT INTO database_registratie (voornaam, achternaam, land, postcode, huisnummer,
    geboortedatum, telefoonnummer, mobielnummer, emailadres, wachtwoord, RegistratieDatum)
    VALUES ('$voornaam', '$achternaam', '$land', '$postcode', '$huisnummer', '$geboortedatum',
    '$telefoonnummer', '$mobielnummer', '$emailadres', '$saltww', '$created_at')";

    /*
        Zo moet error-handlen bij database-queries:
        if (!$db->query(...))
            throw new Exception($db->error);

        of met resultaat:
        $res = $db->query(...)
        if (!$res)
            throw new Exception($db->error);
        of: 
        if (!$res = $db->query(...))
            throw new Exception($db->error);
    */

    if(!$db->query($sql))
        throw new Exception($db->error);
    else{
        mail($emailadres,'Super Internet Shop verificatie e-mail.', 
        'Bedankt voor het registreren bij Super Internet Shop,\r\n
        klik <a href=sisv2.tk/index.php?pag=registratie-geverifieerd.html>hier</a> \r\n
        om uw registratie te bevestigen. \r\n
        Dit is een automatisch gegenereerd bericht, \r\n
        u kunt niet reageren.', 'From:JeMoeder.');
        
        $db->close();
        
        redirect_to("index.php?pag=registratie-succesvol.html");
    }
    
    
    
?>
