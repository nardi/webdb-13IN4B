<?php
    if (!isset($_SESSION['logged-in']))
    {
        echo 'Je moet ingelogd zijn om een bestelling te plaatsen.';
    }
    else if (!isset($_POST['wachtwoord']))
    {
        echo 'Deze pagina vereist wachtwoordverificatie.';
    }
    else
    {
        $gebruiker_id = $_SESSION['gebruiker-id'];
        $wachtwoord = $_POST['wachtwoord'];
        
        $db = connect_to_db();
        $sql = $db->prepare("SELECT wachtwoord FROM Gebruikers WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $_SESSION['gebruiker-id']);
        $sql->execute();
        $sql->bind_result($wwdb);
        $sql->fetch();
        $sql->free_result();

        if (!check_wachtwoord($wachtwoord, $wwdb))
        {
            echo 'Het opgegeven wachtwoord is niet juist.';
            $db->close();
        }
        else
        {
            $ww = Winkelwagen::try_load_from_session();
            
            if ($ww->is_empty())
            {
                echo 'Voeg eerst producten toe aan je winkelwagen voor je een bestelling plaatst.';
                $db->close();
            }
            else
            {
                $sqli_bestelling = $db->prepare("INSERT INTO Bestellingen (gebruiker_id) VALUES (?)");
                $sqli_bestelling->bind_param('i', $gebruiker_id);
                if(!$sqli_bestelling->execute())
                    throw new Exception($sqli_bestelling->error);
                $bestelling_id = $sqli_bestelling->insert_id;
                $sqli_bestelling->free_result();

                foreach ($ww->get_all() as $product_id)
                {
                    $hoeveelheid = $ww->get_amount($product_id);
                    $prijs = $ww->get_price($product_id);
                    $sqli_product = $db->prepare("INSERT INTO Bestelling_Product (bestelling_id, product_id, prijs, hoeveelheid) VALUES (?,?,?,?)");
                    $sqli_product->bind_param('iidi', $bestelling_id, $product_id, $prijs, $hoeveelheid);
                    if(!$sqli_product->execute())
                        throw new Exception($sqli_product->error);
                }
                
                $db->close();
?>
<div class="centered-container">

<h1>Bestelling geplaatst!</h1>

<?php
                require 'bestelling_weergeven.php';
                bestelling_weergeven($bestelling_id);
            }
        }
    }
?>

</div>