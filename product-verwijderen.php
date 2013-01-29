<?php
    if(is_admin()){
        $iid=$_POST['delete'];
        product_verwijderen_func($iid);
        function product_verwijderen_func($pid){
            $id=$pid
            $db = connect_to_db();
            $sqli_preserved_product = $db->prepare("SELECT * FROM Producten WHERE id=?");
            $sqli_preserved_product->bind_param('i',$id);
            $sqli_preserved_product->bind_result($useless,$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$datum_toegevoegd,$cover);
            $sqli_preserved_product->execute();
            $sqli_preserved_product->fetch();
            
            $sqli_preserved_product->free_result();
            
            $sqli_preserved_product = $db->prepare("INSERT INTO Producten_Prullenbak VALUES (?,?,?,?,?,?,?,?,?,?)");
            $sqli_preserved_product->bind_param('ssssssssss', $useless, $titel, $platform_id, $genre_id, $beschrijving, $prijs, $release_date, $voorraad, $datum_toegevoegd, $cover);
            
            $sqli_preserved_product->execute();
            
            $sqli_destroy_product = $db->prepare("DELETE FROM Producten WHERE id=?");
            $sqli_destroy_product->bind_param('i',$id);
            $sqli_destroy_product->execute();
            
        
            echo "<img src='placeholder' /> <br /> <strong> $titel is succesvol verwijderd uit de database.</strong>";
        }
    }
    else
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
    
?>