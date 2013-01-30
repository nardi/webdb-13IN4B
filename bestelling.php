<div class="centered-container">
<?php
    // Eerst een paar checks
    if (!is_logged_in())
    {
        echo 'Je moet ingelogd zijn om je bestellingen te kunnen bekijken.';
    }
    else if (!isset($_GET['id']))
    {
        echo 'Geef een bestelling op.';
    }
    else
    {
        require_once 'bestelling-weergeven.php';
        $id = $_GET['id'];
        
        $db = connect_to_db();
        
        // Een admin kan de verzendstatus aanpassen wanneer de bestelling verzonden is
        if (isset($_POST['verzendstatus']) && is_admin())
        {
            $verzendstatus = $_POST['verzendstatus'];
            $sql = $db->prepare("UPDATE Bestellingen SET verzendstatus = ? WHERE id = ?");
            $sql->bind_param('si', $verzendstatus, $id);
            $sql->execute();
            if ($sql->affected_rows > 0)
            {                
                $status = $verzendstatus == 'Verzonden' ? 'is verzonden' : 'wordt klaargemaakt om te worden verzonden';
                require_once 'email.php';
                bestelling_mail($id, "Statusverandering van uw bestelling #$id bij Super Internet Shop", "Uw bestelling #$id $status.");
            }
        }
        
        $sql = $db->prepare("SELECT gebruiker_id FROM Bestellingen WHERE id = ?");
        $sql->bind_param('i', $id);
        $sql->bind_result($gebruiker_id);
        $sql->execute();
        if (!$sql->fetch())
        {
            echo 'Deze bestelling bestaat niet.';
        }
        // Een admin mag de bestellingen van andere gebruikers bekijken, normale gebruikers niet
        else if ($_SESSION['gebruiker-id'] != $gebruiker_id && !is_admin())
        {
            echo 'Deze bestelling is gedaan door een andere gebruiker.';
        }
        // Als alles klopt wordt de bestelling weergegeven
        else
        {
?>
<h1>Bestelling #<?php echo $id; ?></h1>
<?php
            echo bestelling_weergeven($id, FALSE, is_admin());
        }
    }
?>
</div>