<?php
    require 'main.php';
    require 'adres.php';

    $db = connect_to_db();
    
    $voornaam = safe_POST('voornaam', $db);
    $achternaam = safe_POST('achternaam', $db);
    $postcode = safe_POST('postcode', $db);
    $huisnummer = safe_POST('huisnummer', $db);
    $toevoeging = safe_POST('toevoeging', $db);
    $telefoonnummer = safe_POST('telefoonnummer', $db);
    $emailadres = safe_POST('e-mailadres', $db);
    $wachtwoord = safe_POST('wachtwoord', $db);
    
    $adres_info = json_decode(get_address($postcode, $huisnummer));
    $straat = $adres_info->street;
    $plaats = $adres_info->city;
    
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
    
    $sqli_gebruikers->bind_param('ssssss',$voornaam, $achternaam, $telefoonnummer, $emailadres, $saltww, $registratiedatum);
    
    /*$sql_adressen = "INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat)
    VALUES ('$postcode' , '$huisnummer' , '$toevoeging' , '$plaats' , '$straat')";*/
    
    $sqli_adressen = $db->prepare("INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat)
    VALUES (?,?,?,?,?)");
    
    $sqli_adressen->bind_param('sisss',$postcode , $huisnummer , $toevoeging , $plaats , $straat);
    

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

    if(!$sqli_gebruikers->execute())
        throw new Exception($sqli_gebruikers->error);
    if(!$sqli_adressen->execute())
        throw new Exception($sqli_adressen->error);
    
    mail($emailadres,'Super Internet Shop verificatie e-mail.', 
    'Hoi schat dankje voor het registreren bij Super Internet Shop,<br />
    klik <a href="http://superinternetshop.nl/registratie-geverifieerd.html">hier</a> <br />
    om je registratie te bevestigen. <br />
    Ik heb het erg druk dus <br />
    je kunt niet reageren. Veel plezier op school vandaag.', 'From:JeMoeder.' . "\r\n" . 'Content-type: text/html');
        
    $db->close();
    
    redirect_to("registratie-succesvol.html");
    
    
    
    
?>
