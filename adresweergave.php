<?php
    function adres_weergeven($adres_id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT straat, huisnummer, toevoeging, postcode, plaats FROM Adressen WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $adres_id);
        $sql->execute();
        $sql->bind_result($straat, $huisnummer, $toevoeging, $postcode, $plaats);
        $sql->fetch();  
        $sql->free_result();
        $db->close();
        return "<div class=\"adres\">
                    $straat $huisnummer $toevoeging<br />
                    $postcode $plaats</br>
                </div>"; 
    }
    
    function adres_select($gebruiker_id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT adres_id FROM AdresGebruiker WHERE gebruiker_id = ?");
        $sql->bind_param('i', $gebruiker_id);
        $sql->execute();
        $sql->bind_result($adres_id);
        
        $html = "";
        while ($sql->fetch())
        {
            $html .= "<input type=\"radio\" name=\"adres\" value=\"$adres_id\"/>" .
                      adres_weergeven($adres_id);
        }
        return $html;
    }
?>