<?php
    /*
     * De functie bestelling_weergeven stelt de html voor een bestelling samen. Hierdoor wordt overal dezelfde
     * opmaak gebruikt. $email geeft aan of het voor een e-mail bedoeld is (en er absolute links gebruikt
     * moeten worden) en $editable geeft aan of de verzendstatus bewerkt moet kunnen worden.
     * $canceled geeft aan of deze bestelling geanuleerd is (dan hoeft hij niet betaald te worden).
     */
    function bestelling_weergeven($id, $email = FALSE, $editable = FALSE, $canceled = FALSE)
    {
        require_once 'adresweergave.php';
        
        // $abs maakt de links absoluut
        $abs = '';
        if ($email)
            $abs = $_SERVER['SERVER_NAME'] . '/';
            
        // Een variabele voor de html
        $html = '';
        
        // Haal bestellinginformatie op
        $db = connect_to_db();
        $sql = $db->prepare("SELECT Producten.id, titel, hoeveelheid, Bestelling_Product.prijs,
                                cover, betaalstatus, verzendkosten, verzendstatus, adres_id
                             FROM Producten JOIN Bestelling_Product ON product_id = Producten.id
                             JOIN Bestellingen ON Bestellingen.id = bestelling_id
                             WHERE bestelling_id = ?");
        $sql->bind_param('i', $id);
        $sql->bind_result($product_id, $titel, $hoeveelheid, $prijs, $cover, $betaalstatus, $verzendkosten, $verzendstatus, $adres_id);
        $sql->execute();
        
        // De bovenste rij van de tabel
        $html .= '<table class="product-list">
                  <tbody width="100%">
                    <tr>
                        <th>#</th>
                        <th colspan="2">Product</th>
                        <th>Prijs</th>
                        <th>Hoeveelheid</th>
                        <th>Totaal</th>
                    </tr>';
        
        // $count is voor de PayPal-knop, deze wil de artikelen genummerd hebben
        $count = 1;
        $paypal_info = '';
        $totaalbedrag = 0;
        while ($sql->fetch())
        {
            // De prijs per product
            $productprijs = $hoeveelheid * $prijs;
            
            // Een productrij
            $html .= '<tr>
                        <td class="product-id">
                            <a href="' . $abs . 'item-description.php?id=' . $product_id . '"><span name="product-id">' . $product_id . '</span></a>
                        </td>
                        <td class="product-image">
                            <a href="' . $abs . 'item-description.php?id=' . $product_id . '"><img src="' . $abs . is_valid_cover($cover) . '" alt="' . $titel . '" width="100%" /></a>
                        </td>
                        <td class="product-title">
                            <a href="' . $abs . 'item-description.php?id=' . $product_id . '">' . $titel . '</a>
                        </td>
                        <td>&euro;<span id="price-' . $product_id . '">' . prijs($prijs) . '</span></td>
                        <td>'. $hoeveelheid . '</td>
                        <td>&euro;<span id="productprice-' . $product_id . '">' . prijs($productprijs) . '</span></td>
                    </tr>';
            
            // De info over dit product voor de PayPal-knop
            $paypal_info .= '<input type="hidden" name="item_number_' . $count . '" value="' . $product_id . '">
                             <input type="hidden" name="item_name_' . $count . '" value="' . $titel . '">
                             <input type="hidden" name="amount_' . $count . '" value="' . $prijs . '">
                             <input type="hidden" name="quantity_' . $count . '" value="' . $hoeveelheid . '">' . "\n";
                             
            $totaalbedrag += $productprijs;
            $count++;
        }
        $totaalbedrag += $verzendkosten;
        
        // De onderste rijen
        $html .= '<tr class="bottom-row">
                    <td class="left" colspan="3">Betaalstatus: ' . $betaalstatus . '</td>
                    <td class="right" colspan="2">Verzendkosten:</td>
                    <td>&euro;' . prijs($verzendkosten) . '</td>
                </tr>
                <tr class="bottom-row">
                    <td class="left" colspan="3">';

        // Als de bestelling $editable is moet een select voor de verzendstatus worden weergegeven
        if ($editable)
        {
            $selected = 'selected="selected"';
            $html .= '<span style="float: left;">Verzendstatus:</span> <form action="bestelling.php?id=' . $id . '" method="post">
                        <select name="verzendstatus" style="float: left;">
                            <option value="Wordt verwerkt"' . ($verzendstatus == 'Wordt verwerkt' ? $selected : '') . '>Wordt verwerkt</option>
                            <option value="Verzonden" ' . ($verzendstatus == 'Verzonden' ? $selected : '') . '>Verzonden</option>
                        </select>
                        <input type="submit" value="Aanpassen"/>
                      </form>';
        }
        // Anders wordt als hij nog niet betaald is een knop naar PayPal weerggeven
        else if ($betaalstatus == 'Niet betaald' && !$canceled)
        {
            $html .= '<form action="https://www.paypal.com/us/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_cart"/>
                        <input type="hidden" name="upload" value="1"/>
                        <input type="hidden" name="business" value="paypal@superinternetshop.nl"/>
                        <input type="hidden" name="currency_code" value="EUR"/>
                        <input type="hidden" name="return" value="https://superinternetshop.nl/betaald.php"/>
                        <input type="hidden" name="cancel_return" value="https://superinternetshop.nl/bestelling.php?id=' . $id . '"/>
                        <input type="hidden" name="notify_url" value="https://superinternetshop.nl/ipn.php"/>
                        <input type="hidden" name="custom" value="' . $id . '"/>
                        <input type="hidden" name="no_shipping" value="1"/>
                        <input type="hidden" name="no_note" value="1"/>
                        <input type="hidden" name="handling_cart" value="' . $verzendkosten . '"/>' . "\n"
                        . $paypal_info .        
                        '<input type="submit" value="Betalen via PayPal"/>
                    </form>';
        }
        // Anders wordt de verzendstatus gewoon weergegeven
        else
        {
            $html .= "Verzendstatus: $verzendstatus";
        }
        
        // Het laatste stukje van de tabel en het adres waar hij naartoe verstuurd wordt
        $html .= '</td>
                  <th colspan="2" class="right">Totaalbedrag:</th>
                  <td>&euro;<span id="total-price">' . prijs($totaalbedrag) . '</span></td>
                </tr>
            </tbody>
            </table>
            <br />
            Wordt verstuurd naar:<br/>
            ' . adres_weergeven($adres_id);
            
        return $html;
    }
?>