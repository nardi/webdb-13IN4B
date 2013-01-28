<?php
    function is_op_voorraad($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT voorraad FROM Producten WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        $sql->bind_result($voorraad);
        $sql->fetch();
        $sql->free_result();
        
        return $voorraad > 0;
    }
?>