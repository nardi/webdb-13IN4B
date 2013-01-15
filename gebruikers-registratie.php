<?php
    require 'main.php';

    $db = connect_to_db();

    $voornaam = safe_POST('voornaam', $db);
    $achternaam = safe_POST('achternaam', $db);
    $postcode = safe_POST('postcode', $db);
    $plaats = safe_POST('plaats' , $db);
    $huisnummer = safe_POST('huisnummer', $db);
    $toevoeging = safe_POST('toevoeging', $db);
    $telefoonnummer = safe_POST('telefoonnummer', $db);
    $emailadres = safe_POST('e-mailadres', $db);
    $wachtwoord = safe_POST('wachtwoord', $db);
    $registratiedatum = date('Y-m-d');
    
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
    //Onderstaande is nog niet helemaal af.
    /*$sql_gebruikers = "INSERT INTO Gebruikers (naam, achternaam, telefoonnummer, email, wachtwoord,
    registratie_datum, status)
    VALUES ('$voornaam', '$achternaam', '$telefoonnummer', '$emailadres', '$saltww', '$registratiedatum', '1')";*/
    
    $sqli_gebruikers = $db->prepare("INSERT INTO Gebruikers (naam, achternaam, telefoonnummer, email, wachtwoord,
    registratie_datum, status)
    VALUES (?,?,?,?,?,?,'1')");
    
    $sqli_gebruikers->bind_param('ssssss','$voornaam', '$achternaam', '$telefoonnummer', '$emailadres', '$saltww', '$registratiedatum');
    
    /*$sql_adressen = "INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat)
    VALUES ('$postcode' , '$huisnummer' , '$toevoeging' , '$plaats' , '$straat')";*/
    
    $sqli_adressen = $db->prepare("INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat)
    VALUES (?,?,?,?,?)");
    
    $sqli_adressen->bind_param('sssss','$postcode' , '$huisnummer' , '$toevoeging' , '$plaats' , '$straat');
    

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

    if(!$db->query($sqli_gebruikers) || !$db->query($sqli_adressen))
        throw new Exception($db->error);
    else{
        mail($emailadres,'Super Internet Shop verificatie e-mail.', 
        'Bedankt voor het registreren bij Super Internet Shop,<br />
        klik <a href="sisv2.tk/index.php?pag=registratie-geverifieerd.html">hier</a> <br />
        om uw registratie te bevestigen. <br />
        Dit is een automatisch gegenereerd bericht, <br />
        u kunt niet reageren.', 'From:JeMoeder.' . "\r\n" . 'Content-type: text/html');
        
        $db->close();
        
        redirect_to("index.php?pag=registratie-succesvol.html");
    }
    
    
    
?>
