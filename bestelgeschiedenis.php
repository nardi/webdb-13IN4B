<div class="bestellingen-geschiedenis centered-container">
<?php
    if (!isset($_SESSION['gebruiker-id']))
    {
        echo 'Je moet ingelogd zijn om een bestelling te plaatsen.';
    }
    else
    {
?>
  <h1><center><b>Bestellingen</b></center></h1>
    <hr width="100%">
    <center><b>Bestelgeschiedenis</b></center><br/>
    <div class="centered-container"> 
<?php
        $db = connect_to_db();
        $bestellingen = $db->prepare("SELECT id, timestamp FROM Bestellingen WHERE gebruiker_id = ?");
        $bestellingen->bind_param('i', $_SESSION['gebruiker-id']);
        $bestellingen->bind_result($bestelling_id, $timestamp);
        $bestellingen->execute();
        $bestellingen->store_result();
?>
    <table style="display: inline-block;">
        <tr>
            <th></th>
            <th>Totaalbedrag</th>
            <th>Datum</th>
        </tr>
<?php
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
        <tr class="clickable-item" onclick="window.location = 'bestelling.php?id=<?php echo $bestelling_id; ?>';">
            <td>Bestelling #<?php echo $bestelling_id; ?></td>
            <td>&euro;<?php echo price($totaalprijs); ?></td>
            <td><?php echo $timestamp; ?></td>
        </tr>
<?php
            $producten->free_result();
        }
        $bestellingen->free_result();
        $db->close();
?>
    </table>
    </div>
    <hr width="100%">
    <a href="bestellingen-lopende.html"><input type="submit" value="Lopende bestellingen"></a><br />
<?php
    }
?>
</div>