<?php
    $db = connect_to_db();
    
    $sqli_id = $db->prepare("SELECT id FROM Producten");
    $sqli_id->bind_result($id);
    $sqli_id->execute();
    $sqli_id->store_result();
    $sqli_id->free_result();
    ?><script>alert("Main");</script><?php
    var_dump($_POST);
    while($sqli_id->fetch()){
        echo "ID=$id <br>";
        ?><script>alert("while");</script><?php
        //Probleem zi hier ergens. Zelfs als ik alle velden enable krijg ik nog steeds undefined errors.
        $test= "titel".$id;
        echo "$test <br><hr>";
        
        if(isset($_POST['titel'.$id])){
            ?><script>alert("if");</script><?php
            $titel=$_POST['titel'.$id];
            $platform_id=$_POST['platform'.$id];
            $genre_id=$_POST['genre'.$id];
            $beschrijving=$_POST['beschrijving'.$id];
            $prijs=$_POST['prijs'.$id];
            $release_date=$_POST['release'.$id];
            $voorraad=$_POST['voorraad'.$id];
            
            if(isset($_POST['image'.$id])){
                try{
                    $cover=upload_image('image'.$id);
                }
                catch(Exeption $img){
                    $cover=NULL;
                }
            }
            
            $sqli_verander = $db->prepare("UPDATE Producten SET titel=?, platform_id=?,genre_id=?,beschrijving=?, prijs=?, release_date=?, voorraad=? WHERE id=?");
            
            var_dump($sqli_verander);
            
            $sqli_verander->bind_param('siisdsis',$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$id);
            
            $sqli_verander->execute();
            
            if($cover!=NULL){
                $sqli_verander_cover = $db->prepare("UPDATE Producten SET cover=? WHERE id=?");
                $sqli_verander_cover->bind_param('ss',$cover,$id);
                $sqli_verander_cover->execute();
                
            }
        }    
        //$titeltest=$_POST['titel22'];    
        //echo "$titeltest";

    }
    $db->close();
?>
    