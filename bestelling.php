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
        
        if (isset($_POST['verzendstatus']) && is_admin())
        {
            $verzendstatus = $_POST['verzendstatus'];
            $sql = $db->prepare("UPDATE Bestellingen SET verzendstatus = ? WHERE id = ?");
            $sql->bind_param('si', $verzendstatus, $id);
            $sql->execute();
        }
        
        $sql = $db->prepare("SELECT gebruiker_id FROM Bestellingen WHERE id = ?");
        $sql->bind_param('i', $id);
        $sql->bind_result($gebruiker_id);
        $sql->execute();
        if (!$sql->fetch())
        {
            echo 'Deze bestelling bestaat niet.';
        }
        else if ($_SESSION['gebruiker-id'] != $gebruiker_id && !is_admin())
        {
            echo 'Deze bestelling is gedaan door een andere gebruiker.';
        }
        else
        {
?>
<h1>Bestelling #<?php echo $id; ?></h1>
<?php
            require 'bestelling-weergeven.php';
            echo bestelling_weergeven($id, FALSE, is_admin());
        }
    }
?>
</div>