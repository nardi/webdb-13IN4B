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
    
    
    $sqli_producten = $db->prepare("INSERT INTO Producten (titel, beschrijving, prijs, release_date, voorraad, platform, genre)
    VALUES (?,?,?,?,?,?,?)");
    
    $sqli_producten->bind_param('sssssss',$titel, $beschrijving, $prijs, $release_date, $voorraad, $platform, $genre);

    if(!$sqli_producten->execute())
        throw new Exception($sqli_producten->error);

    $db->close();
    
    redirect_to("index.php?pag=product-toevoegen-succesvol.html");
?>
