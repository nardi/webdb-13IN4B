<?php
    function voorraad($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT voorraad FROM Producten WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        $sql->bind_result($voorraad);
        if (!$sql->fetch())
            return 0;
        $sql->free_result();
        $db->close();
        
        return $voorraad;
    }
    
    function is_op_voorraad($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT voorraad, verwijderd FROM Producten WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        $sql->bind_result($voorraad, $verwijderd);
        if (!$sql->fetch())
            return false;
        $sql->free_result();
        $db->close();
        
        return $voorraad > 0 && $verwijderd != 1;
    }
?>