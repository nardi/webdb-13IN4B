<?php
    require 'main.php';

    $db = connect_to_db();

    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $release_date = $_POST['release_date'];
    $voorraad = $_POST['voorraad'];
    $platform = $_POST['platform'];
    $genre = $_POST['genre'];
    
    
    if ($_FILES["file"]["error"] > 0)
      {
      echo "Error: " . $_FILES["file"]["error"] . "<br>";
      }
    else
      {
      echo "Upload: " . $_FILES["file"]["name"] . "<br>";
      echo "Type: " . $_FILES["file"]["type"] . "<br>";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
      echo "Stored in: " . $_FILES["file"]["tmp_name"];
      }

    
    
    
    $sqli_producten = $db->prepare("INSERT INTO Producten (titel, beschrijving, prijs, release_date, voorraad, platform_id, genre_id)
    VALUES (?,?,?,?,?,?,?)");
    
    $sqli_producten->bind_param('sssssss', $titel, $beschrijving, $prijs, $release_date, $voorraad, $platform, $genre);

    if(!$sqli_producten->execute())
        throw new Exception($sqli_producten->error);

    $db->close();
    
    redirect_to("product-toevoegen-succesvol.html");
?>
