<div class="centered-container">
<?php
    require 'bestelling-weergeven.php';
    
    if (!isset($_SESSION['logged-in']))
    {
        echo 'Je moet ingelogd zijn om een bestelling te plaatsen.';
    }
    
    $ww = Winkelwagen::try_load_from_session();
        
    if ($ww->is_empty())
    {
        echo 'Voeg eerst producten toe aan je winkelwagen voor je een bestelling plaatst.';
    }
    else
    {
        if (isset($_POST['wachtwoord']))
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
                $verzendkosten = $ww->get_shipping();
                $sqli_bestelling = $db->prepare("INSERT INTO Bestellingen (gebruiker_id, verzendkosten) VALUES (?, ?)");
                $sqli_bestelling->bind_param('id', $gebruiker_id, $verzendkosten);
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
                
                $email_sql = $db->prepare("SELECT email FROM Gebruikers WHERE id = ?");
                $email_sql->bind_param('i', $gebruiker_id);
                $email_sql->bind_result($email);
                $email_sql->execute();
                if ($email_sql->fetch())
                {

                    mail($email,
                         'Uw bestelling bij Super Internet Shop',
                         '<html>
                          <head>
                            <link rel="stylesheet" type="text/css" href="http://superinternetshop.nl/productlijst.css" />
                            <link rel="stylesheet" type="text/css" href="http://superinternetshop.nl/centering.css" />
                          </head>
                          <body>
                            Bedankt voor uw bestelling bij Super Internet Shop!<br/>Hier is nogmaals te zien wat u precies besteld heeft:<br/>' . bestelling_weergeven($bestelling_id, TRUE) .
                         '</body>
                          </html>',
                         "From: contact@superinternetshop.nl\r\nContent-type: text/html");
                }
                $email_sql->free_result();
                
                $db->close();
                $ww->remove_all();
                $ww->save_to_session();
?>

<h1>Bestelling geplaatst!</h1>
<p>Klik onderaan op de knop "Betalen via Paypal" om voor de bestelling te betalen.<br/>
Dit kan ook op een later moment via uw accountoverzicht, maar tot dan wordt uw bestelling nog niet verstuurd!</p>
<?php
                echo bestelling_weergeven($bestelling_id, FALSE);
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
<p>Voer uw wachtwoord opnieuw in ter controle voor u een bestelling plaatst:</p>
<form method="post">
    <input type="password" name="wachtwoord"><br/>
    <input type="submit" value="Plaats bestelling"><br/>
</form>
<?php
        }
    }
?>
</div>