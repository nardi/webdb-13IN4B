<!--
Deze file zorgt ervoor dat de gebruiker een adres kan toevoegen. 
Vervolgens wordt het toegevoegde adres in de Adressen tabel gestopt.
In de AdresGebruiker tabel wordt het id van het adres met het id van de gebruiker verbonden.
-->

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
        
        $sqli_adressen = $db->prepare("INSERT INTO Adressen (postcode, huisnummer, toevoeging, plaats, straat)
        VALUES (?,?,?,?,?)");
        $sqli_adressen->bind_param('sisss',$postcode , $huisnummer , $toevoeging , $plaats , $straat);
        $sqli_adressen->execute();
        
        //id van adres en id van gebruiker aan tabel AdresGebruiker toewijzen
        $adres_id = $sqli_adressen->insert_id;
        $gebruiker_id = $_SESSION['gebruiker-id'];
        
        $sqli_adresgebr = $db->prepare("INSERT INTO AdresGebruiker (adres_id, gebruiker_id) VALUES (?,?)");
        $sqli_adresgebr->bind_param('ii', $adres_id, $gebruiker_id);
        $sqli_adresgebr->execute(); 
        
        $db->close();
        
        redirect_to("adres-toevoegen-succesvol.html");
        
        exit();  
    }

    else{
       echo preg_match($validPostcode, $postcode).
       preg_match($validHuis, $huisnummer);
    }
  }  
?>