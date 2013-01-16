<div id="bestelling">

<h1>Uw bestelling</h1>

<form>
    <table class="product-list">
        <tr>
            <th>#</th>
            <th colspan="2">Product</th>
            <th>Prijs</th>
            <th>Hoeveelheid</th>
            <th>Totaal</th>
        </tr>
        <tr>
            <td class="product-id"><a href="item-description.html">100</a></td>
            <td class="product-image"><a href="item-description.html"><img src="images/products/1.jpg" /></a></td>
            <td class="product-title"><a href="item-description.html">Battletoads 2</a></td>
            <td>&euro;42,00</td>
            <td><input type="text" name="amount-100" value="2" /></td>
            <td>&euro;84,00</td>
        </tr>
        <tr>
            <td class="product-id"><a href="item-description.html">2</a></td>
            <td class="product-image"><a href="item-description.html"><img src="images/products/2.jpg" /></a></td>
            <td class="product-title"><a href="item-description.html">SUPER Battletoads X Arcade Edition</a></td>
            <td>&euro;84,00</td>
            <td><input type="text" name="amount-2" value="1" /></td>
            <td>&euro;84,00</td>
        </tr>
        <tr>
            <td class="product-id"><a href="item-description.html">1</a></td>
            <td class="product-image"><a href="item-description.html"><img src="images/products/1.jpg" /></a></td>
            <td class="product-title"><a href="item-description.html">Battletoads</a></td>
            <td>&euro;42,00</td>
            <td><input type="text" name="amount-1" value="3" /></td>
            <td>&euro;126,00</td>
        </tr>
        <tr class="total-price">
            <td class="update-button" colspan="3"><input type="submit" value="Update hoeveelheden" /></td>
            <th colspan="2">Totale prijs:</td>
            <td><span class="price">&euro;294,00<span></td>
        </tr>
    </table>
</form>

<form action="https://www.paypal.com/us/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="paypal@superinternetshop.nl">
    <input type="hidden" name="currency_code" value="EUR">
    <input type="hidden" name="notify_url" value="http://superinternetshop.nl/ipn.php">
    
    <input type="hidden" name="item_number_1" value="100">
    <input type="hidden" name="item_name_1" value="Battletoads 2">
    <input type="hidden" name="amount_1" value="42.00">
    <input type="hidden" name="quantity_1" value="2">
    
    <input type="hidden" name="item_number_2" value="2">
    <input type="hidden" name="item_name_2" value="SUPER Battletoads X Arcade Edition">
    <input type="hidden" name="amount_2" value="84.00">
    <input type="hidden" name="quantity_2" value="1">
    
    <input type="hidden" name="item_number_3" value="1">
    <input type="hidden" name="item_name_3" value="Battletoads">
    <input type="hidden" name="amount_3" value="42.00">
    <input type="hidden" name="quantity_3" value="3">
    
    <input type="submit" value="Betalen met PayPal">
</form>

</div>