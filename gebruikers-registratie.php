<?php
    

    $db = connect_to_db();
    
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $postcode = $_POST['postcode'];
    $huisnummer = $_POST['huisnummer'];
    $toevoeging = $_POST['toevoeging'];
    $telefoonnummer = $_POST['telefoonnummer'];
    $telefoonnummer2 = $_POST['telefoonnummer2'];
    $telelfoonnummerTot;
    $emailadres = $_POST['e-mailadres'];
    $wachtwoord = $_POST['wachtwoord'];
    
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
    
    $validNaam = '/^[a-z\s-\']{1,256}$/i';
    $validPostcode = '/^[0-9]{4}[\s-]?[a-z]{2}$/i';
    $validTel1 = '/^[0-9]{2,4}$/';
    $validTel2 = '/^[0-9]{6,8}$/';
    $validTelTot = '/^[0-9]{10}$/';
    $validHuis = '/^[0-9]{1,5}$/';
    $validMail='/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';
    $validWachtwoord='/^.+$/';
    
    if(preg_match($validNaam, $voornaam)&&
       preg_match($validNaam, $achternaam)&&
       preg_match($validPostcode, $postcode)&&
       preg_match($validHuis, $huisnummer)&&
       preg_match($validTel1, $telefoonnummer)&&
       preg_match($validTel2, $telefoonnummer2)&&
       preg_match($validMail, $emailadres)&&
       preg_match($validWachtwoord, $wachtwoord)){
        $telefoonnummerTot = $telefoonnummer . '-' . $telefoonnummer2;
            
        $sqli_gebruikers = $db->prepare("INSERT INTO Gebruikers (naam, achternaam, telefoonnummer, email, wachtwoord,
        registratie_datum, status)
        VALUES (?,?,?,?,?,?,'1')");
        
        $sqli_gebruikers->bind_param('ssssss',$voornaam, $achternaam, $telefoonnummerTot, $emailadres, $saltww, $registratiedatum);
        
        //id gebruiker aan AdresGebruiker toewijzen 
        $gebruiker_id = $sqli_gebruikers->mysql_insert_id;
        echo $gebruiker_id;
        
        /*$sql_adressen = "INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat)
        VALUES ('$postcode' , '$huisnummer' , '$toevoeging' , '$plaats' , '$straat')";*/

        $sqli_adressen = $db->prepare("INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat)
        VALUES (?,?,?,?,?)");
        
        $sqli_adressen->bind_param('sisss',$postcode , $huisnummer , $toevoeging , $plaats , $straat);
    

        //id adres aan AdresGebruiker toewijzen
        $adres_id = $sqli_adressen->insert_id;
        $sqli_adresgebr = $db->prepare("INSERT INTO AdresGebruiker (adres_id, gebruiker_id) VALUES (?,?)");
        $sqli_adresgebr->bind_param('ii',$adres_id , $gebruiker_id);


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
            if($sqli_gebruikers->error == "Duplicate entry '$emailadres' for key 'email'"){
                throw new Exception("Dit e-mail adres bestaat al, probeer '<a href=inloggen.php>in te loggen.</a>'");
            }
            else
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
    }
    
    else
       //redirect_to("error.php?msg=Foei je mag niet via een URL hier komen.");
       echo preg_match($validNaam, $voornaam).
       preg_match($validNaam, $achternaam).
       preg_match($validPostcode, $postcode).
       preg_match($validHuis, $huisnummer).
       preg_match($validTel1, $telefoonnummer).
       preg_match($validTel2, $telefoonnummer2).
       preg_match($validMail, $emailadres).
       preg_match($validWachtwoord, $wachtwoord);
    
?>
