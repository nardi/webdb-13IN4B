<?php
    if (is_admin())
    {
        $db = connect_to_db();
    
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $release_date = $_POST['release_date'];
    $voorraad = $_POST['voorraad'];
    $platform = $_POST['platform'];
    $genre = $_POST['genre'];
    $image = $_FILES['image'];
    
       
    
    $sqli_producten = $db->prepare("INSERT INTO Producten (titel, beschrijving, prijs, release_date, voorraad, platform_id, genre_id, cover)
    VALUES (?,?,?,?,?,?,?,?)");
    
    $sqli_producten->bind_param('ssssssss', $titel, $beschrijving, $prijs, $release_date, $voorraad, $platform, $genre, $image);

        if(!$sqli_producten->execute())
            throw new Exception($sqli_producten->error);

    $db->close();
    
    
    
    redirect_to("product-toevoegen-succesvol.html");
    }
?>
