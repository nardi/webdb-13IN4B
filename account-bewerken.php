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
    $validWachtwoord='/^.+$/';
    
    if(preg_match($validNaam, $voornaam)&&
       preg_match($validNaam, $achternaam)&&
       preg_match($validPostcode, $postcode)&&
       preg_match($validHuis, $huisnummer)&&
       preg_match($validTel1, $telefoonnummer)&&
       preg_match($validTel2, $telefoonnummer2)&&
       preg_match($validMail, $emailadres)){
        $telefoonnummerTot = $telefoonnummer . '-' . $telefoonnummer2;
        
        /*
        $sqli_gebruikers = $db->prepare("UPDATE Gebruikers naam = ?, achternaam = ?, telefoonnummer = ?, email = ? WHERE id= '".$_SESSION['gebruiker-id']."' ");

        $sqli_gebruikers->bind_param('ssss',$voornaam, $achternaam, $telefoonnummerTot, $emailadres);
        */
        
        //**********************************************************************************************
        $sqli_gebruikers = $db->prepare("UPDATE Gebruikers SET naam = ?, achternaam = ?, telefoonnummer = ?, email = ? WHERE id= '".$_SESSION['gebruiker-id']."'");
        
        $sqli_gebruikers->bind_param('ssss',$voornaam, $achternaam, $telefoonnummerTot, $emailadres);

        $sqli_adressen = $db->prepare("UPDATE SET postcode = ?, huisnummer = ?, toevoeging = ?, plaats = ?, straat = ? FROM Adressen JOIN AdresGebruiker ON Adressen.id = adres_id WHERE id= '".$_SESSION['gebruiker-id']."'");
        
        $sqli_adressen->bind_param('sssss',$postcode , $huisnummer , $toevoeging , $plaats , $straat);
        
        //***********************************************************************************************
        /*$sql_adressen = "INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat)
        VALUES ('$postcode' , '$huisnummer' , '$toevoeging' , '$plaats' , '$straat')";*/
        /*
        $sqli_adressen = $db->prepare("UPDATE Adressen (postcode, huisnummer, toevoeging, plaats, straat)
        VALUES (?,?,?,?,?)");
        
        $sqli_adressen->bind_param('sisss',$postcode , $huisnummer , $toevoeging , $plaats , $straat);
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
    }
    
    else
       //redirect_to("error.php?msg=Foei je mag niet via een URL hier komen.");
       echo preg_match($validNaam, $voornaam).
       preg_match($validNaam, $achternaam).
       preg_match($validPostcode, $postcode).
       preg_match($validHuis, $huisnummer).
       preg_match($validTel1, $telefoonnummer).
       preg_match($validTel2, $telefoonnummer2).
       preg_match($validMail, $emailadres);
    
?>
