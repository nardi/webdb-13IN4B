<?php
    $db = connect_to_db();
    
    $sqli_id = $db->prepare("SELECT id FROM Producten");
    $sqli_id->bind_result($id);
    $sqli_id->execute();
    ?><script>alert("Main");</script><?php
    while($sqli_id->fetch()){
        ?><script>alert("while");</script><?php
        if($_POST['titel'.$id]){
            ?><script>alert("if");</script><?php
            $titel=$_POST['titel'.$id];
            $platform_id=$_POST['platform'.$id];
            $genre_id=$_POST['genre'.$id];
            $beschrijving=$_POST['beschrijving'.$id];
            $prijs=$_POST['prijs'.$id];
            $release_date=$_POST['release'.$id];
            $voorraad=$_POST['voorraad'.$id];
            $cover=upload_image('image'.$id);
            
            $sqli_verander = $db->prepare("UPDATE Producten SET titel=?, platform_id=?,genre_id=?,beschrijving=?, prijs=?, release_date=?, voorraad=? WHERE id=?");
            
            $sqli_verander->bind_param('siisdsis',$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$id);
            
            $sqli_verander->execute();
            
            if(isset($cover)){
                $sqli_verander_cover = $db->prepare("UPDATE Producten SET cover=? WHERE id=?");
                $sqli_verander_cover->bind_param('ss',$cover,$id);
                $sqli_verander_cover->execute();
                
            }
        }    
            

    }
    $db->close();
?>
    