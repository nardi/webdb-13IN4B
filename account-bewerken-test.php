<?php
	if ((!isset($_SESSION['logged-in']))) {
	?>
	<pre>
U bent niet ingelogd!
	</pre>
	<?php
	}
	else {

    require 'main.php';

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
    
    
    function SqlThatShit(){
        $sqli_gebruikers = $db->prepare("UPDATE Gebruikers SET naam, achternaam, telefoonnummer, email WHERE id= '".$_SESSION['gebruiker-id']."' LIMIT 1 VALUES (?,?,?,?)");
        
        $sqli_gebruikers->bind_param('ssss',$voornaam, $achternaam, $telefoonnummerTot, $emailadres);
        
        $sqli_adressen = $db->prepare("UPDATE Adressen (postcode, huisnummer, toevoeging, plaats, straat)
        VALUES (?,?,?,?,?)");

        $sqli_adressen->bind_param('sisss',$postcode , $huisnummer , $toevoeging , $plaats , $straat);

        if(!$sqli_gebruikers->execute())
            throw new Exception($sqli_gebruikers->error);
        if(!$sqli_adressen->execute())
            throw new Exception($sqli_adressen->error);
        
        mail($emailadres,'Super Internet Shop verificatie e-mail.', 
        'Hoi schat dankje voor het registreren bij Super Internet Shop,<br />
        klik <a href="http://superinternetshop.nl/registratie-geverifieerd.html">hier</a> <br />
        om je registratie te bevestigen. <br />
        Je hebt succesvol wijzigingen aangebracht!', 'From:JeMoeder.' . "\r\n" . 'Content-type: text/html');
            
        $db->close();
        
         
    }
    
    function doesThisMakeSense(){
        $validNaam = '/^[a-z]{1,256}$/i';
        $validPostcode = '/^[0-9]{4}[\s-]?[a-z]{2}$/i';
        $validTel1 = '/^[0-9]{2,4}$/';
        $validTel2 = '/^[0-9]{6,8}$/';
        $validTelTot = '/^[0-9]{10}$/';
        $validHuis = '/^[0-9]{1,5}$/';
        $validMail='/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i';
        $validWachtwoord='/^[0-9a-zA-Z]{+}$/';
        
        if(preg_match($validNaam, $voornaam )===1 &&
           preg_match($validNaam, $achternaam )===1 &&
           preg_match($validPostcode, $postcode )===1 &&
           preg_match($validHuis, $huisnummer )===1 &&
           preg_match($validTel1, $telefoonnummer )===1 &&
           preg_match($validTel2, $telefoonnummer2 )===1 &&
           preg_match($validMail, $emailadres )===1 &&
           preg_match($validWachtwoord, $wachtwoord )===1){
                $telefoonnummerTot = $telefoonnummer . '-' . $telefoonnummer2;
                SqlThatShit();
                redirect_to("registratie-succesvol.html");
        }
        
        else
            redirect_to("error.html?msg=Foei je mag niet via een URL hier komen.");
           
    }
    
    }
?>
