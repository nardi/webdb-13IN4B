<?php
    function adres_weergeven($adres_id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT straat, huisnummer, toevoeging, postcode, plaats FROM Adressen WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $adres_id);
        $sql->execute();
        $sql->bind_result($straat, $huisnummer, $toevoeging, $postcode, $plaats);
        $sql->fetch();
?>
<div class="adres">
<?php echo $straat; ?> <?php echo $huisnummer; ?> <?php echo $toevoeging; ?><br />
<?php echo $postcode; ?> <?php echo $plaats; ?></br>
</div>
<?php      
        $sql->free_result();
        $db->close();
    }
    
    function adres_select($gebruiker_id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT adres_id FROM AdresGebruiker WHERE gebruiker_id = ?");
        $sql->bind_param('i', $gebruiker_id);
        $sql->execute();
        $sql->bind_result($adres_id);

        while ($sql->fetch())
        {
?>
<input type="radio" name="adres" value="<?php echo $adres_id; ?>"/>
<?php adres_weergeven($adres_id); ?>
<?php
        }
    }
?>