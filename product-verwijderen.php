<?php
    if(is_admin()){
        function product_verwijderen_func($pid, $titel){
            $thistitel =$titel;
            $id=$pid;
            $db = connect_to_db();
            $sqli_verwijderen = $db->prepare("UPDATE Producten SET verwijderd=1 WHERE id=?");
            $sqli_verwijderen->bind_param('i',$id);
            $sqli_verwijderen->execute();
        
            echo "<img src='images/labels/verwijderd.gif' /> <br /> <strong> $titel is succesvol verwijderd uit de database.</strong>";
        }
        if(isset($_POST['delete'])){
            $iid=$_POST['delete'];
            product_verwijderen_func($iid);
        }
    }
    else
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
    
?>