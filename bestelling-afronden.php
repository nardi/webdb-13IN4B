<?php
    if (!isset($_SESSION['logged-in']))
    {
        echo 'Je moet ingelogd zijn om een bestelling te plaatsen.';
        exit();
    }
    if (!isset($_POST['wachtwoord']))
    {
        echo 'Deze pagina vereist wachtwoordverificatie.';
        exit();
    }
    
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
        exit();
    }
    
    $ww = Winkelwagen::try_load_from_session();
    
    if ($ww->is_empty())
    {
        echo 'Voeg eerst producten toe aan je winkelwagen voor je een bestelling plaatst.';
        $db->close();
        exit();
    }
?>

<div id="bestelling">

<h1>Uw bestelling</h1>

<?php
    echo $ww->display(FALSE);
?>
    
<?php
    $sqli_bestelling = $db->prepare("INSERT INTO Bestellingen (gebruiker_id) VALUES (?)");
    $sqli_bestelling->bind_param('i', $gebruiker_id);
    if(!$sqli_bestelling->execute())
        throw new Exception($sqli_bestelling->error);
    $bestelling_id = $sqli_bestelling->insert_id;
    $sqli_bestelling->free_result();
?>

<form action="https://www.sandbox.paypal.com/us/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="paypal_1358181822_biz@nardilam.nl">
    <input type="hidden" name="currency_code" value="EUR">
    <input type="hidden" name="notify_url" value="http://superinternetshop.nl/ipn.php">
    <input type="hidden" name="custom" value="<?php echo $bestelling_id; ?>">

<?php
    $count = 1;
    foreach ($ww->get_all() as $product_id)
    {
        $hoeveelheid = $ww->get_amount($product_id);
        $prijs = $ww->get_price($product_id);
        $titel = $ww->get_title($product_id);
?>        
    <input type="hidden" name="item_number_<?php echo $count; ?>" value="<?php echo $product_id; ?>">
    <input type="hidden" name="item_name_<?php echo $count; ?>" value="<?php echo $titel; ?>">
    <input type="hidden" name="amount_<?php echo $count; ?>" value="<?php echo $prijs; ?>">
    <input type="hidden" name="quantity_<?php echo $count; ?>" value="<?php echo $hoeveelheid; ?>">
<?php
        $sqli_product = $db->prepare("INSERT INTO Bestelling_Product (bestelling_id, product_id, prijs, hoeveelheid) VALUES (?,?,?,?)");
        $sqli_product->bind_param('iidi', $bestelling_id, $product_id, $prijs, $hoeveelheid);
        if(!$sqli_product->execute())
            throw new Exception($sqli_product->error);
        $count++;
    }
    
    $db->close();
?>
    <input type="submit" value="Betalen met PayPal">
</form>

</div>