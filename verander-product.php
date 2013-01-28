<?php
    $db = connect_to_db();
    
    /*$sqli_id = $db->prepare("SELECT id FROM Producten");
    $sqli_id->bind_result($id);
    $sqli_id->execute();
    $sqli_id->store_result();
   // $sqli_id->free_result();*/
    ?><script>//alert("Main");</script><?php
    var_dump($_POST);
    //while($sqli_id->fetch()){
        //echo "ID=$id <br>";
        ?><script>//alert("while");</script><?php
        if(isset($_POST['titel'])){
            ?><script>//alert("if");</script><?php
            $titel=$_POST['titel'];
            $platform_id=$_POST['platform'];
            $genre_id=$_POST['genre'];
            $beschrijving=$_POST['beschrijving'];
            $prijs=$_POST['prijs'];
            $release_date=$_POST['release'];
            $voorraad=$_POST['voorraad'];
            $id=$_POST['id'];
            
           try{
                echo "TRY";
                $image = upload_image("file");
            }
            catch(Exeption $img){
                $image=NULL;
            }
            
            
            $sqli_verander = $db->prepare("UPDATE Producten SET titel=?, platform_id=?,genre_id=?,beschrijving=?, prijs=?, release_date=?, voorraad=? WHERE id=?");
            
            var_dump($sqli_verander);
            
            $sqli_verander->bind_param('siisdsis',$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$id);
            
            $sqli_verander->execute();
            
            if($cover!=NULL){
                echo"NULL!";
                $sqli_verander_cover = $db->prepare("UPDATE Producten SET cover=? WHERE id=?");
                $sqli_verander_cover->bind_param('ss',$image,$id);
                $sqli_verander_cover->execute();
                
            }
        }    
        //$titeltest=$_POST['titel22'];    
        //echo "$titeltest";

    
    $db->close();
?>
    