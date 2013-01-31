<div class="centered-container">
<div class="bestellingenlijst">
<?php
    if (!isset($_SESSION['gebruiker-id']))
    {
        echo 'Je moet ingelogd zijn om je bestellingen te bekijken.';
    }
    else
    {
        require_once 'totaalbedrag.php';
?>
  <h1><center><b>Bestellingen</b></center></h1>
<?php
        $db = connect_to_db();
        $aantal_bestellingen = 0;
        $lopende_bestellingen = $db->prepare("SELECT id, timestamp, betaalstatus, verzendstatus FROM Bestellingen WHERE gebruiker_id = ? AND verzendstatus != 'Verzonden' ORDER BY timestamp DESC");
        $lopende_bestellingen->bind_param('i', $_SESSION['gebruiker-id']);
        $lopende_bestellingen->bind_result($bestelling_id, $timestamp, $betaalstatus, $verzendstatus);
        $lopende_bestellingen->execute();
        $lopende_bestellingen->store_result();
        $aantal_bestellingen += $lopende_bestellingen->affected_rows;
        if ($lopende_bestellingen->affected_rows > 0)
        {
?>  
    <hr width="100%">
    <center><b>Lopende bestellingen</b></center><br/>
    <table>
        <tr>
            <th></th>
            <th>Totaalbedrag</th>
            <th>Datum</th>
            <th>Betaalstatus</th>
            <th>Verzendstatus</th>
        </tr>
<?php
        }
        while ($lopende_bestellingen->fetch())
        {
            $totaalbedrag = totaalbedrag($bestelling_id);
?>
        <tr class="clickable-item" onclick="window.location = 'bestelling.php?id=<?php echo $bestelling_id; ?>';">
            <td>Bestelling #<?php echo $bestelling_id; ?></td>
            <td>&euro;<?php echo prijs_opmaak($totaalbedrag); ?></td>
            <td><?php echo date('d-m-Y', strtotime($timestamp)); ?></td>
            <td><?php echo $betaalstatus; ?></td>
            <td><?php echo $verzendstatus; ?></td>
        </tr>
<?php
        }
        $lopende_bestellingen->free_result();
?>
    </table>
<?php
        $bestellingen = $db->prepare("SELECT id, timestamp, betaalstatus, verzendstatus FROM Bestellingen WHERE gebruiker_id = ? AND verzendstatus = 'Verzonden' ORDER BY timestamp DESC");
        $bestellingen->bind_param('i', $_SESSION['gebruiker-id']);
        $bestellingen->bind_result($bestelling_id, $timestamp, $betaalstatus, $verzendstatus);
        $bestellingen->execute();
        $bestellingen->store_result();
        $aantal_bestellingen += $bestellingen->affected_rows;
        if ($bestellingen->affected_rows > 0)
        {
?>
    <hr width="100%">
    <center><b>Oude bestellingen</b></center><br/>
    <table>
        <tr>
            <th></th>
            <th>Totaalbedrag</th>
            <th>Datum</th>
            <th>Betaalstatus</th>
            <th>Verzendstatus</th>
        </tr>
<?php
        }
        while ($bestellingen->fetch())
        {
            $totaalbedrag = totaalbedrag($bestelling_id);
?>
        <tr class="clickable-item" onclick="window.location = 'bestelling.php?id=<?php echo $bestelling_id; ?>';">
            <td>Bestelling #<?php echo $bestelling_id; ?></td>
            <td>&euro;<?php echo prijs_opmaak($totaalbedrag); ?></td>
            <td><?php echo date('d-m-Y', strtotime($timestamp)); ?></td>
            <td><?php echo $betaalstatus; ?></td>
            <td><?php echo $verzendstatus; ?></td>
        </tr>
<?php
        }
        $bestellingen->free_result();
        $db->close();
?>
    </table>
<?php
        if ($aantal_bestellingen == 0)
            echo 'Je hebt nog geen bestellingen geplaatst.';
    }
?>
</div>
</div>