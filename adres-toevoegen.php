<?php
    if (!isset($_SESSION['logged-in'])){
        echo 'U moet uiteraard ingelogd zijn om uw account aan te passen.';
        exit();
    }
    else {
    $db = connect_to_db();
      
    $postcode = $_POST['postcode'];
    $huisnummer = $_POST['huisnummer'];
    $toevoeging = $_POST['toevoeging'];    
    $nonStrictPostcode = '/^[0-9]{4}[\s-][a-z]{2}$/i';
    
    if(preg_match($nonStrictPostcode, $postcode)){
        $postcode=substr($postcode,0,4).substr($postcode,5);
    }
    
    $adres_info = json_decode(get_address($postcode, $huisnummer));
    $straat = $adres_info->street;
    $plaats = $adres_info->city;
    
    $validPostcode = '/^[0-9]{4}[\s-]?[a-z]{2}$/i';
    $validHuis = '/^[0-9]{1,5}$/';

    if(preg_match($validPostcode, $postcode)&&
       preg_match($validHuis, $huisnummer)){
       
        $gebruikersid = $_SESSION['gebruiker-id'];
        
        $sqli_adressen = $db->prepare("INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat) VALUES (?,?,?,?,?)");
    
        $sqli_adressen->bind_param('sisss',$postcode , $huisnummer , $toevoeging , $plaats , $straat);
        
        if(!$sqli_adressen->execute())
            throw new Exception($sqli_adressen->error);
    
        //id adres aan AdresGebruiker toewijzen
        $adres_id = $sqli_adressen->insert_id;
        $sqli_adresgebr = $db->prepare("INSERT INTO AdresGebruiker (adres_id, gebruiker_id) VALUES (?,?)");
        $sqli_adresgebr->bind_param('ii',$adres_id , $gebruikersid);
        $sqli_adresgebr->execute();
       
        redirect_to("adres-toegevoegd-succesvol.html");
        $db->close();
        exit();  
    }

    else{
       echo preg_match($validPostcode, $postcode).
       preg_match($validHuis, $huisnummer);
    }
  }  
?>