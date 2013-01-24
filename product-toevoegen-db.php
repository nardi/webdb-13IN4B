<?php
    if (is_admin())
    {
      
        /* Code voor het uplaoden van afbeeldingen gebasseerd op het voorbeeld van w3.
         * URL: http://www.w3schools.com/php/php_file_upload.asp
         */
        $image = upload_image("image");
  
        $db = connect_to_db();
        
        $titel = $_POST['titel'];
        $beschrijving = $_POST['beschrijving'];
        $prijs = $_POST['prijs'];
        $release_date = $_POST['release_date'];
        $voorraad = $_POST['voorraad'];
        $platform = $_POST['platform'];
        $genre = $_POST['genre'];

        
        $sqli_producten = $db->prepare("INSERT INTO Producten (titel, beschrijving, prijs, release_date, voorraad, platform_id, genre_id, cover)
        VALUES (?,?,?,?,?,?,?,?)");
        
        $sqli_producten->bind_param('ssssssss', $titel, $beschrijving, $prijs, $release_date, $voorraad, $platform, $genre, $image);

            if(!$sqli_producten->execute())
                throw new Exception($sqli_producten->error);

        $db->close();
    
    }
?>

<link rel="stylesheet" type="text/css" href="registratie-succesvol.css" />
<link rel="stylesheet" type="text/css" href="registratie-succesvol-classic-theme.css" />

<div class="product-toevoegen-succesvol-container">
    <div id="logo-registratie-succesvol" title="Super Internet Shop">
    </div>
    
    <div class="bedankje">
        <?php
        if(isset($errormsg)) {
            echo $errormsg;
        }
        else {
            echo '<p class="bedankje"> U heeft succesvol een product toegevoegd! <br/></p>';
        }
        ?>
        <a href="frontpage.html">
        <p class="bedankje">Klik hier om terug te keren naar het hoofdmenu</p>
   
        </a>
    </div>
    
</div>