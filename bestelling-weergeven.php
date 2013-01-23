<?php
    function bestelling_weergeven($id)
    {
        global $imagedir;
        $db = connect_to_db();
        $sql = $db->prepare("SELECT Producten.id, titel, hoeveelheid, Bestelling_Product.prijs, cover, betaalstatus
                             FROM Producten JOIN Bestelling_Product ON product_id = Producten.id
                             JOIN Bestellingen ON Bestellingen.id = bestelling_id
                             WHERE bestelling_id = ?");
        $sql->bind_param('i', $id);
        $sql->bind_result($product_id, $titel, $hoeveelheid, $prijs, $cover, $betaalstatus);
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
        $totaalprijs = 0;
        $count = 1;
        $paypal_info = '';
        while ($sql->fetch())
        {            
            $productprijs = $hoeveelheid * $prijs;
?>
        <tr>
            <td class="product-id"><a href="item-description.php?id=<?php echo $id; ?>"><span name="product-id"><?php echo $id; ?></span></a></td>
            <td class="product-image"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo '<img src="'.$imagedir . $cover .'" />';?></a></td>
            <td class="product-title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></td>
            <td>&euro;<span id="price-<?php echo $id; ?>"><?php echo $prijs; ?></span></td>
            <td><input type="text" class="product-amount" value="<?php echo $hoeveelheid; ?>" disabled="disabled" /></td>
            <td>&euro;<span id="productprice-<?php echo $id; ?>"><?php echo $productprijs; ?></span></td>
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
            <th colspan="3"><?php echo "Betaalstatus: $betaalstatus"; ?></th>
            <th colspan="2">Totale prijs:</th>
            <td>&euro;<span id="total-price" class="price"><?php echo $totaalprijs; ?><span></td>
        </tr>
        <tr>
            <td class="payment-status" colspan="3">
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
    <?php echo $paypal_info; ?>        
    <input type="submit" value="Betalen via PayPal">
</form>
<?php
        }
?>
            </td>
        </tr>
    </table>
<?php
    }
?>