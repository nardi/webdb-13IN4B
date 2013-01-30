<div id="frontpage">
<?php
    $db = connect_to_db();
    
    $on_sale = $db->prepare('SELECT Producten.id, titel, Producten.prijs, Aanbiedingen.prijs, cover FROM Producten JOIN Aanbiedingen ON product_id = Producten.id WHERE verwijderd != 1 AND start_datum <= CURRENT_DATE AND eind_datum >= CURRENT_DATE LIMIT 8');
    $on_sale->bind_result($id, $titel, $oude_prijs, $prijs, $cover);
    $on_sale->execute();
    if ($on_sale->fetch())
    {
?>

<div id="on-sale" class="category">

<h1>In de aanbieding</h1>
<?php
        do
        {
?>

<div class="product-hilite">
    <a href="item-description.php?id=<?php echo $id; ?>">
    <img src="<?php echo is_valid_cover($cover); ?>" alt="<?php echo $titel; ?>" />
    <div id="desc" class="vcenter-container">
        <div class="vcenter">
            <p class="title"><?php echo $titel; ?></p>
            <p>van</p>
            <p class="old-price">&euro;<?php echo prijs($oude_prijs); ?></p>
            <p>voor</p>
            <p class="price">&euro;<?php echo prijs($prijs); ?></p>
        </div>
    </div>
    </a>
</div>
<?php
        } while($on_sale->fetch());
?>

</div>
<?php
    }

    $new_releases = $db->prepare('SELECT Producten.id, titel, cover, Producten.prijs, Aanbiedingen.prijs FROM Producten LEFT JOIN Aanbiedingen ON product_id = Producten.id AND start_datum <= CURRENT_DATE AND eind_datum >= CURRENT_DATE WHERE verwijderd != 1 AND release_date < CURRENT_DATE ORDER BY release_date DESC LIMIT 8');
    $new_releases->bind_result($id, $titel, $cover, $prijs, $aanbiedingsprijs);
    $new_releases->execute();
    if ($new_releases->fetch())
    {
?>

<div id="new-releases" class="category">

<h1>Nieuwe releases</h1>

<div class="product-row">
<?php
        $count = 1;
        do
        {
            if (!isset($aanbiedingsprijs))
                $aanbiedingsprijs = null;
            product_thumb($id, is_valid_cover($cover), $titel, $prijs, $aanbiedingsprijs);
            
            if ($count % 4 == 0)
            echo '</div><div class="product-row">';
        
            $count++;
        } while ($new_releases->fetch());
?>
</div>

</div>
<?php
    }
    $new_releases->free_result();

    $pre_orders = $db->prepare('SELECT Producten.id, titel, release_date, cover, Producten.prijs, Aanbiedingen.prijs FROM Producten LEFT JOIN Aanbiedingen ON product_id = Producten.id AND start_datum <= CURRENT_DATE AND eind_datum >= CURRENT_DATE WHERE verwijderd != 1 AND release_date > CURRENT_DATE ORDER BY release_date ASC LIMIT 8');
    $pre_orders->bind_result($id, $titel, $datum, $cover, $prijs, $aanbiedingsprijs);
    $pre_orders->execute();
    if ($pre_orders->fetch())
    {
?>

<div id="preorders" class="category">

<h1>Binnenkort beschikbaar</h1>
<?php
        $count = 1;
        do
        {
            if (!isset($aanbiedingsprijs))
                $aanbiedingsprijs = null;
            product_thumb($id, is_valid_cover($cover), $titel, $prijs, $aanbiedingsprijs, $datum);
            
            if ($count % 4 == 0)
            echo '</div><div class="product-row">';
        
            $count++;
        } while ($pre_orders->fetch());
?>

</div>
<?php  
    }
    $pre_orders->free_result();
    
    $db->close();
?>

</div>