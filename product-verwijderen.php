<?php
    if(is_admin()){
        function product_verwijderen_func($pid, $titel){
            $thistitel =$titel;
            $id=$pid;
            $db = connect_to_db();
            $sqli_verwijderen = $db->prepare("UPDATE Producten SET verwijderd=1 WHERE id=?");
            $sqli_verwijderen->bind_param('i',$id);
            $sqli_verwijderen->execute();
        
            echo "<img src='images/labels/verwijderd.gif' /> <br /> <strong> $titel is succesvol verwijderd.</strong>";
            redirect_to('/', '3000');
        }
        if(isset($_POST['deleteId']) && isset($_POST['deleteTitle'])){
            $iid=$_POST['deleteId'];
            $titel = $_POST['deleteTitle'];
            product_verwijderen_func($iid, $titel);
        }
    }
    else
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
    
?>