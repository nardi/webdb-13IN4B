<div class="centered-container">
<?php
    require_once 'email.php';
    
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
        else if (isset($_POST['annuleren']))
        {
            bestelling_mail($id, "Uw bestelling #$id bij Super Internet Shop is geannuleerd", "Uw bestelling #$id is geannuleerd. Als u dit niet zelf gedaan heeft kan dit komen door een achtergebleven betaling. Als u nog vragen heeft, neem dan contact met ons op via onze site of antwoord op deze e-mail.");
            $sql = $db->prepare("DELETE FROM Bestellingen WHERE id = ? LIMIT 1");
            $sql->bind_param('i', $id);
            $sql->execute();
            echo 'Deze bestelling is geannuleerd.';
        }
        // Als alles klopt wordt de bestelling weergegeven
        else
        {
?>
<script src="bestelling.js" type="text/javascript"></script>

<h1>Bestelling #<?php echo $id; ?></h1>
<?php
            echo bestelling_weergeven($id, FALSE, is_admin());
?>
<div id="annuleringsbevestiging">
    <input type="button" onclick="laadBevestiging()">Bestelling annuleren</input>
</div>
        }
    }
?>
</div>