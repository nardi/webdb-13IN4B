<div class="centered-container">
<?php
    if (!isset($_SESSION['logged-in']))
    {
        echo 'Je moet ingelogd zijn om je bestellingen te kunnen bekijken.';
    }
    else if (!isset($_GET['id']))
    {
        echo 'Geef een bestelling op.';
    }
    else
    {
        $id = $_GET['id'];
        
        $db = connect_to_db();
        $sql = $db->prepare("SELECT gebruiker_id FROM Bestellingen WHERE id = ?");
        $sql->bind_param('i', $id);
        $sql->bind_result($gebruiker_id);
        $sql->execute();
        if (!$sql->fetch())
        {
            echo 'Deze bestelling bestaat niet.';
        }
        else if ($_SESSION['gebruiker-id'] != $gebruiker_id)
        {
            echo 'Deze bestelling is gedaan door een andere gebruiker.';
        }
        else
        {
?>
<h1>Bestelling #<?php echo $id; ?></h1>
<?php
            require 'bestelling-weergeven.php';
            bestelling_weergeven($bestelling_id);
        }
    }
?>
</div>