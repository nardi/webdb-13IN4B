<?php
    require 'product-verwijderen.php';
    $db = connect_to_db();
    var dump($_POST);
    $sqli_id = $db->prepare("SELECT id FROM Producten");
    $sqli_id->bind_result($id);
    $sqli_id->execute();
    $sqli_id->store_result();
    while($sqli_id->fetch()){
        if(isset($_POST["titel$id"]) && $_POST["verwijderen"] != 'teverwijderen'){
            $titel=$_POST["titel$id"];
            $platform_id=$_POST["platform$id"];
            $genre_id=$_POST["genre$id"];
            $beschrijving=$_POST["beschrijving$id"];
            $prijs=$_POST["prijs$id"];
            $release_date=$_POST["release$id"];
            $voorraad=$_POST["voorraad$id"];
            
           try{
                $image = upload_image("file$id");
            }
            catch(Exception $img){
                $image=NULL;
            }
            
            
            $sqli_verander = $db->prepare("UPDATE Producten SET titel=?, platform_id=?,genre_id=?,beschrijving=?, prijs=?, release_date=?, voorraad=? WHERE id=?");
            
            $sqli_verander->bind_param('siisdsis',$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$id);
            
            $sqli_verander->execute();
            
            if($image!=NULL){
                $sqli_verander_cover = $db->prepare("UPDATE Producten SET cover=? WHERE id=?");
                $sqli_verander_cover->bind_param('ss',$image,$id);
                $sqli_verander_cover->execute();
                
            }
        } 
        
        else if($_POST["verwijderen$id"] == 'teverwijderen'){
            $titel=$_POST["titel$id"];
            product_verwijderen_func($id, $titel);
        }        
    }
    $db->close();
?>
    