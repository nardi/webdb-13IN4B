<?php
    if (is_admin())
    {
      
        /* Code voor het uplaoden van afvbeeldingen gebasseerd op het voorbeeld van w3.
         * URL: http://www.w3schools.com/php/php_file_upload.asp
         */
      
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $_FILES["image"]["name"]));
        if ((($_FILES["image"]["type"] == "image/gif")
        || ($_FILES["image"]["type"] == "image/jpeg")
        || ($_FILES["image"]["type"] == "image/png")
        || ($_FILES["image"]["type"] == "image/pjpeg"))
        && in_array($extension, $allowedExts)) {
            if ($_FILES["image"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["image"]["error"] . "<br>";
            }
            else
            {
                if (file_exists("../uploads/" . $_FILES["image"]["name"]))
                {
                    echo $_FILES["image"]["name"] . " already exists. ";
                }
                else
                {
                    if(!move_uploaded_file($_FILES["image"]["tmp_name"],
                    "/datastore/webdb13IN4B/uploads/" . $_FILES["image"]["name"])) {
                        throw new Exception("Het uploaden van het bestand is mislukt");
                    }  
                            
                    $image = $_FILES["image"]["naam"];
                }
            }
        }
        else
        {
            echo "Ongeldig bestand. Bestand moet .jpg, .jpeg, .png of .gif zijn";
        }
  
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
    
    
    
    redirect_to("product-toevoegen-succesvol.html");
    }
?>
