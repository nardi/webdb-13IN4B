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

    $wwhash = hash('sha256', $wachtwoord);
    /*               '.       
        .-""-._     \ \.--|  
       /       "-..__) .-'   
     ?_______?             /     
      \'-.__,   .__.,'       
       `'----'._\--'  
     * Whale whale whale, what have we here?
     *
     * Leuk, maar deze functie kan niet misgaan.
     * Ook is dat error-handlen specifiek voor het mysqli-object bedoeld,
     * andere functies werken weer anders.
     */

    $sql = "INSERT INTO database_registratie (voornaam, achternaam, land, postcode, huisnummer,
    geboortedatum, telefoonnummer, mobielnummer, emailadres, wachtwoord, RegistratieDatum)
    VALUES ('$voornaam', '$achternaam', '$land', '$postcode', '$huisnummer', '$geboortedatum',
    '$telefoonnummer', '$mobielnummer', '$emailadres', '$wwhash', '$created_at')";

    /*
        Zo moet error-handlen bij database-queries:
        if (!$db->query(...))
            throw new Exception($db->error);

        of met resultaat:
        $res = $db->query(...)
        
        if (!$res)
            throw new Exception($db->error);
        
        of: 
        if (!$res = $db->query(...)) (misschien, weet niet)
            throw new Exception($db->error);
    */

    if(!$db->query($sql))
        throw new Exception($db->error);
    else
        redirect("index.php?pag=registratie-succesvol.html");

    $db->close();
?>
