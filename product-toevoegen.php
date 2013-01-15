<?php
    require 'main.php';

    $db = connect_to_db();

    $titel = safe_POST('titel', $db);
    $beschrijving = safe_POST('beschrijving', $db);
    $prijs = safe_POST('prijs', $db);
    $release_date = safe_POST('release_date' , $db);
    $voorraad = safe_POST('voorraad', $db);
    $platform = safe_POST('platform' , $db);
    $genre = safe_POST('genre', $db);
    
    //Onderstaande is nog niet helemaal af.
    /*$sql_gebruikers = "INSERT INTO Gebruikers (naam, achternaam, telefoonnummer, email, wachtwoord,
    registratie_datum, status)
    VALUES ('$voornaam', '$achternaam', '$telefoonnummer', '$emailadres', '$saltww', '$registratiedatum', '1')";*/
    
    $sqli_producten = $db->prepare("INSERT INTO Producten (titel, platform, genre, beschrijving, prijs,
    release_date, voorraad)
    VALUES (?,?,?,?,?,?,?)");
    
    $sqli_producten->bind_param('ssssss',$titel, $platform, $genre, $beschrijving, $prijs, $release_date, $voorraad);
    
    
    if(!$sqli_producten->execute())
        throw new Exception($sqli_producten->error);

    $db->close();
    
    redirect_to("index.php?pag=product-toevoegen-succesvol.html");
?>
