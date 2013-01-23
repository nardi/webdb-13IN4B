<div class="bestellingen-geschiedenis centered-container">
<?php
    if (!isset($_SESSION['gebruiker-id']))
    {
        echo 'Je moet ingelogd zijn om een bestelling te plaatsen.';
    }
    else
    {
?>
  <div align="left"> 
  <h1><center><b>Bestellingen</b></center></h1>
    <hr width="100%">
    <center><b>Bestelgeschiedenis</b></center><br/>
<?php
        $db = connect_to_db();
        $bestellingen = $db->prepare("SELECT id FROM Bestellingen WHERE gebruiker_id = ?");
        $bestellingen->bind_param('i', $_SESSION['gebruiker-id']);
        $bestellingen->bind_result($bestelling_id);
        $bestellingen->execute();
        $bestellingen->store_result();
        while ($bestellingen->fetch())
        {
            $producten = $db->prepare("SELECT hoeveelheid, prijs FROM Bestelling_Product WHERE bestelling_id = ?");
            $producten->bind_param('i', $bestelling_id);
            $producten->bind_result($hoeveelheid, $prijs);
            $producten->execute();
            $totaalprijs = 0;
            while ($producten->fetch())
                $totaalprijs += $hoeveelheid * $prijs;
?>
<a href="bestelling.php?id=<?php echo $bestelling_id; ?>">Bestelling #<?php echo $bestelling_id; ?> met een totaal van &euro;<?php echo $totaalprijs; ?></a><br/>
<?php
            $producten->free_result();
        }
        $bestellingen->free_result();
        $db->close();
?>
    <hr width="100%">
    <div align="center"> 
    <a href="bestellingen-lopende.html"><input type="submit" value="Lopende bestellingen"></a><br>
    </div>
<?php
    }
?>
</div>