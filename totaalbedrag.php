<?php
    function totaalbedrag($bestelling_id)
    {
        $db = connect_to_db();
        $totaalbedrag = 0;
        
        $vz = $db->prepare("SELECT verzendkosten FROM Bestellingen WHERE id = ?");
        $vz->bind_param('i', $bestelling_id);
        $vz->bind_result($verzendkosten);
        $vz->execute();
        $vz->fetch();
        $totaalbedrag += $verzendkosten;
        
        $producten = $db->prepare("SELECT hoeveelheid, prijs FROM Bestelling_Product WHERE bestelling_id = ?");
        $producten->bind_param('i', $bestelling_id);
        $producten->bind_result($hoeveelheid, $prijs);
        $producten->execute();
        while ($producten->fetch())
            $totaalbedrag += $hoeveelheid * $prijs;

        $producten->free_result();
        $db->close();
        return $totaalbedrag;
    }
?>