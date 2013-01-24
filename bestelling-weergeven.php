<?php
    function bestelling_weergeven($id, $email)
    {
        global $imagedir;
        $abs = '';
        if ($email)
            $abs = $_SERVER['SERVER_NAME'] . '/';
        $html = '';
        $db = connect_to_db();
        $sql = $db->prepare("SELECT Producten.id, titel, hoeveelheid, Bestelling_Product.prijs,
                                cover, betaalstatus, verzendkosten, verzendstatus
                             FROM Producten JOIN Bestelling_Product ON product_id = Producten.id
                             JOIN Bestellingen ON Bestellingen.id = bestelling_id
                             WHERE bestelling_id = ?");
        $sql->bind_param('i', $id);
        $sql->bind_result($product_id, $titel, $hoeveelheid, $prijs, $cover, $betaalstatus, $verzendkosten, $verzendstatus);
        $sql->execute();
        $html .= '    <table class="product-list">
        <tr>
            <th>#</th>
            <th colspan="2">Product</th>
            <th>Prijs</th>
            <th>Hoeveelheid</th>
            <th>Totaal</th>
        </tr>';
        $totaalprijs = 0;
        $count = 1;
        $paypal_info = '';
        while ($sql->fetch())
        {            
            $productprijs = $hoeveelheid * $prijs;
            $html .= '        <tr>
            <td class="product-id"><a href="' . $abs . 'item-description.php?id=' . $product_id . '"><span name="product-id">' . $product_id . '</span></a></td>
            <td class="product-image" width="80pt"><a href="' . $abs . 'item-description.php?id=' . $product_id . '"><img src="' . $abs . is_valid_cover($cover) . '" width="100%" /></a></td>
            <td class="product-title"><a href="' . $abs . 'item-description.php?id=' . $product_id . '">' . $titel . '</a></td>
            <td>&euro;<span id="price-' . $product_id . '">' . price($prijs) . '</span></td>
            <td>'. $hoeveelheid . '</td>
            <td>&euro;<span id="productprice-' . $product_id . '">' . price($productprijs) . '</span></td>
        </tr>';
            $paypal_info .= '<input type="hidden" name="item_number_' . $count . '" value="' . $product_id . '">
                             <input type="hidden" name="item_name_' . $count . '" value="' . $titel . '">
                             <input type="hidden" name="amount_' . $count . '" value="' . $prijs . '">
                             <input type="hidden" name="quantity_' . $count . '" value="' . $hoeveelheid . '">';
            $totaalprijs += $productprijs;
            $count++;
        }
        $totaalprijs += $verzendkosten;
        $html .= '        <tr class="bottom-row">
            <td class="left" colspan="3">Betaalstatus: ' . $betaalstatus . '</td>
            <td class="right" colspan="2">Verzendkosten:</td>
            <td>&euro;' . price($verzendkosten) . '</td>
        </tr>
        <tr class="bottom-row">
            <td class="left" colspan="3">';
        if ($betaalstatus == 'Niet betaald')
        {
            $html .= '<form action="https://www.sandbox.paypal.com/us/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="paypal_1358181822_biz@nardilam.nl">
    <input type="hidden" name="currency_code" value="EUR">
    <input type="hidden" name="return" value="http://superinternetshop.nl/betaald.php">
    <input type="hidden" name="notify_url" value="http://superinternetshop.nl/ipn.php">
    <input type="hidden" name="custom" value="' . $id . '">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="no_note" value="1">
    <input type="hidden" name="handling_cart" value="' . $verzendkosten . '">'
    . $paypal_info .        
    '<input type="submit" value="Betalen via PayPal">
</form>';
        }
        else
        {
            $html .= "Verzendstatus: $verzendstatus";
        }
        $html .= '            </td>
            <th colspan="2" class="right">Totale prijs:</th>
            <td>&euro;<span id="total-price">' . price($totaalprijs) . '</span></td>
        </tr>
    </table>';
        return $html;
    }
?>