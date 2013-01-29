<div class="centered-container">
<?php
    require_once 'winkelwagen.class.php';
    require_once 'bestelling-weergeven.php';
    require_once 'voorraad.php';
    
    $ww = Winkelwagen::try_load_from_session();
    
    if (!is_logged_in())
    {
        echo 'Je moet ingelogd zijn om een bestelling te plaatsen.';
    }
    else if (!is_verified())
    {
        echo 'Je e-mailadres moet geverifiëerd zijn om een bestelling te plaatsen. Klik op de link in de e-mail die naar je toe gestuurd is.';
    }
    else if ($ww->is_empty())
    {
        echo 'Voeg eerst producten toe aan je winkelwagen voor je een bestelling plaatst.';
    }
    else
    {
        $voorraad = TRUE;
        foreach($ww->get_all() as $id)
            $voorraad = $voorraad && is_op_voorraad($id);
        
        if (!$voorraad)
        {
            echo 'Sommige producten in uw winkelwagen zijn niet meer op voorraad.';
        }
        else if (isset($_POST['wachtwoord']))
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
                $adres_id = $_POST['adres'];
                $verzendkosten = $ww->get_shipping();
                $sqli_bestelling = $db->prepare("INSERT INTO Bestellingen (gebruiker_id, verzendkosten, adres_id) VALUES (?, ?, ?)");
                $sqli_bestelling->bind_param('idi', $gebruiker_id, $verzendkosten, $adres_id);
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
                    $voorraad = $db->prepare("UPDATE Producten SET voorraad = voorraad - ? WHERE id = ?");
                    $voorraad->bind_param('ii', $hoeveelheid, $product_id);
                    if(!$voorraad->execute())
                        throw new Exception($voorraad->error);
                }
                
                require_once 'email.php';
                bestelling_mail($bestelling_id, 'Uw bestelling bij Super Internet Shop', 'Bedankt voor uw bestelling bij Super Internet Shop!');
                
                $db->close();
                $ww->remove_all();
                $ww->save_to_session();
?>

<h1>Bestelling geplaatst!</h1>
<p>Klik onderaan op de knop "Betalen via Paypal" om voor de bestelling te betalen.<br/>
Dit kan ook op een later moment via uw accountoverzicht, maar tot dan wordt uw bestelling nog niet verstuurd!</p>
<?php
                echo bestelling_weergeven($bestelling_id);
            }
        }
        else
        {
?>

<h1>Uw huidige bestelling</h1>

<?php
            echo $ww->display(FALSE);
?>
<br/>
<form method="post">
<p>Kies hieronder het adres waarnaar de bestelling verstuurd moet worden:</p>
<?php
            require_once 'adresweergave.php';
            echo adres_select($_SESSION['gebruiker-id']);
?>
<br/>
<p>Voer uw wachtwoord opnieuw in ter controle voor u een bestelling plaatst:</p>
    <input type="password" name="wachtwoord"><br/>
    <input type="submit" value="Plaats bestelling"><br/>
</form>
<?php
        }
    }
?>
</div>