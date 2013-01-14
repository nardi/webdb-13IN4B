<?php
    require 'main.php';

    $db = connect_to_db();

    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $land = $_POST['land'];
    $postcode = $_POST['postcode'];
    $huisnummer = $_POST['huisnummer'];
    $geboortedatum = $_POST['jaar'] . '-' . $_POST['maand'] . '-' . $_POST['dag'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $mobielnummer = $_POST['mobielnummer'];
    $emailadres = $_POST['e-mailadres'];
    $wachtwoord = $_POST['wachtwoord'];
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
    else
        redirect_to("index.php?pag=registratie-succesvol.html");

    $db->close();
    
    mail('$emailadres','Super Internet Shop verificatie e-mail.', 
    'Bedankt voor het registreren bij Super Internet Shop,\n
    klik hier om uw registratie te bevestigen. \n
    Dit is een automatisch gegenereerd bericht, \n
    u kunt niet reageren.', 'From:Je moeder.');
?>
