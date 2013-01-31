<?php
    require 'product-verwijderen.php';
    $db = connect_to_db();
    
    $sqli_id = $db->prepare("SELECT id FROM Producten");
    $sqli_id->bind_result($id);
    $sqli_id->execute();
    //Dit bestand moet worden teruggezet naar een andere GIT versie.
    $sqli_id->store_result();
   // $sqli_id->free_result();*/
    ?><script>//alert("Main");</script><?php
    var_dump($_POST);
    while($sqli_id->fetch()){
        //echo "ID=$id <br>";
        ?><script>//alert("while");</script><?php
        if(isset($_POST["titel$id"]) && $_POST["verwijderen"] != 'teverwijderen'){
            ?><script>//alert("if");</script><?php
            $titel=$_POST["titel$id"];
            $platform_id=$_POST["platform$id"];
            $genre_id=$_POST["genre$id"];
            $beschrijving=$_POST["beschrijving$id"];
            $prijs=$_POST["prijs$id"];
            $release_date=$_POST["release$id"];
            $voorraad=$_POST["voorraad$id"];
            //$id=$_POST['idee'];
            
           try{
                echo "TRY";
                $image = upload_image("file$id");
            }
            catch(Exception $img){
                $image=NULL;
            }
            
            
            $sqli_verander = $db->prepare("UPDATE Producten SET titel=?, platform_id=?,genre_id=?,beschrijving=?, prijs=?, release_date=?, voorraad=? WHERE id=?");
            
            var_dump($sqli_verander);
            
            $sqli_verander->bind_param('siisdsis',$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$id);
            
            $sqli_verander->execute();
            
            if($image!=NULL){
                echo"Niet NULL!";
                $sqli_verander_cover = $db->prepare("UPDATE Producten SET cover=? WHERE id=?");
                $sqli_verander_cover->bind_param('ss',$image,$id);
                $sqli_verander_cover->execute();
                
            }
            
            else if($image==NULL){
                echo "HOERA NULL! $id";
            }
        } 

        else if($_POST["verwijderen$id"] == 'teverwijderen'){
            product_verwijderen_func($id, $titel);
        }
        //$titeltest=$_POST['titel22'];    
        //echo "$titeltest";

    }
    $db->close();
?>
    