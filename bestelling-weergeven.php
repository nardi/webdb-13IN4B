<?php
    function bestelling_weergeven($id)
    {
        global $imagedir;
        $db = connect_to_db();
        $sql = $db->prepare("SELECT Producten.id, titel, hoeveelheid, Bestelling_Product.prijs,
                                cover, betaalstatus, verzendkosten, verzendstatus
                             FROM Producten JOIN Bestelling_Product ON product_id = Producten.id
                             JOIN Bestellingen ON Bestellingen.id = bestelling_id
                             WHERE bestelling_id = ?");
        $sql->bind_param('i', $id);
        $sql->bind_result($product_id, $titel, $hoeveelheid, $prijs, $cover, $betaalstatus, $verzendkosten,$verzendstatus);
        $sql->execute();
?>
    <table class="product-list">
        <tr>
            <th>#</th>
            <th colspan="2">Product</th>
            <th>Prijs</th>
            <th>Hoeveelheid</th>
            <th>Totaal</th>
        </tr>
<?php
        $totaalprijs = $verzendkosten;
        $count = 1;
        $paypal_info = '';
        while ($sql->fetch())
        {            
            $productprijs = $hoeveelheid * $prijs;
?>
        <tr>
            <td class="product-id"><a href="item-description.php?id=<?php echo $product_id; ?>"><span name="product-id"><?php echo $product_id; ?></span></a></td>
            <td class="product-image"><a href="item-description.php?id=<?php echo $product_id; ?>"><?php echo '<img src="'. $imagedir . $cover . '" />';?></a></td>
            <td class="product-title"><a href="item-description.php?id=<?php echo $product_id; ?>"><?php echo $titel; ?></a></td>
            <td>&euro;<span id="price-<?php echo $product_id; ?>"><?php echo $prijs; ?></span></td>
            <td><input type="text" class="product-amount" value="<?php echo $hoeveelheid; ?>" disabled="disabled" /></td>
            <td>&euro;<span id="productprice-<?php echo $product_id; ?>"><?php echo $productprijs; ?></span></td>
        </tr>
<?php
            $paypal_info .= '<input type="hidden" name="item_number_' . $count . '" value="' . $product_id . '">
                             <input type="hidden" name="item_name_' . $count . '" value="' . $titel . '">
                             <input type="hidden" name="amount_' . $count . '" value="' . $prijs . '">
                             <input type="hidden" name="quantity_' . $count . '" value="' . $hoeveelheid . '">';
            $totaalprijs += $productprijs;
            $count++;
        }
?>
        <tr class="bottom-row">
            <td class="left" colspan="3"><?php echo "Betaalstatus: $betaalstatus"; ?></td>
            <td class="right" colspan="2">Verzendkosten:</td>
            <td>&euro;<?php echo $verzendkosten; ?></td>
        </tr>
        <tr class="bottom-row">
            <td class="left" colspan="3">
<?php
        if ($betaalstatus == 'Niet betaald')
        {
?>
<form action="https://www.sandbox.paypal.com/us/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="paypal_1358181822_biz@nardilam.nl">
    <input type="hidden" name="currency_code" value="EUR">
    <input type="hidden" name="return" value="http://superinternetshop.nl/betaald.php">
    <input type="hidden" name="notify_url" value="http://superinternetshop.nl/ipn.php">
    <input type="hidden" name="custom" value="<?php echo $id; ?>">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="handling_cart" value="<?php echo $verzendkosten; ?>">
    <?php echo $paypal_info; ?>        
    <input type="submit" value="Betalen via PayPal">
</form>
<?php
        }
        else
        {
            echo "Verzendstatus: $verzendstatus";
        }
?>
            </td>
            <th colspan="2" class="right">Totale prijs:</th>
            <td>&euro;<span id="total-price"><?php echo $totaalprijs; ?></span></td>
        </tr>
    </table>
<?php
    }
?>