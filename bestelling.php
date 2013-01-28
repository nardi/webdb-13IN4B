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
        require 'bestelling-weergeven.php';
        $id = $_GET['id'];
        
        $db = connect_to_db();
        
        if (isset($_POST['verzendstatus']) && is_admin())
        {
            $verzendstatus = $_POST['verzendstatus'];
            $sql = $db->prepare("UPDATE Bestellingen SET verzendstatus = ? WHERE id = ?");
            $sql->bind_param('si', $verzendstatus, $id);
            $sql->execute();
            if ($sql->affected_rows > 0)
            {
                $email_sql = $db->prepare("SELECT email FROM Bestellingen JOIN Gebruikers ON Gebruikers.id = gebruiker_id WHERE Bestellingen.id = ?");
                $email_sql->bind_param('i', $id);
                $email_sql->bind_result($email);
                $email_sql->execute();
                if ($email_sql->fetch())
                {
                    $status = $verzendstatus == 'Verzonden' ? 'is verzonden.' : 'wordt klaargemaakt om te worden verzonden.';
                    $html = '<html>
                              <body>
                                Uw bestelling #$id ' . $status . '<br/>Hier is nogmaals te zien wat u precies besteld heeft:<br/>' . bestelling_weergeven($bestelling, TRUE) .
                             '</body>
                             </html>';
                    $css = file_get_contents('main.css') . "\n" . file_get_contents('productlijst.css');
                    require 'email.php';
                    leuke_mail($email, "Statusverandering van uw bestelling #$id bij Super Internet Shop", $html, $css);
                }
                $email_sql->free_result();
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
        else if ($_SESSION['gebruiker-id'] != $gebruiker_id && !is_admin())
        {
            echo 'Deze bestelling is gedaan door een andere gebruiker.';
        }
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