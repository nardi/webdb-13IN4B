<div id="frontpage">
<?php
    $db = connect_to_db();
    
    $on_sale = $db->prepare('SELECT Producten.id, titel, Producten.prijs, Aanbiedingen.prijs, cover FROM Producten JOIN Aanbiedingen ON product_id = Producten.id WHERE start_datum <= CURRENT_DATE AND eind_datum >= CURRENT_DATE LIMIT 8');
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
    <img src="<?php echo is_valid_cover($cover); ?>" />
    <div id="desc" class="vcenter-container">
        <div class="vcenter">
            <p class="title"><?php echo $titel; ?></p>
            <p>van</p>
            <p class="old-price">&euro;<?php echo $oude_prijs; ?></p>
            <p>voor</p>
            <p class="price">&euro;<?php echo $prijs; ?></p>
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

    $new_releases = $db->prepare('SELECT id, titel, prijs, cover FROM Producten WHERE release_date < CURRENT_DATE ORDER BY release_date DESC LIMIT 8');
    $new_releases->bind_result($id, $titel, $prijs, $cover);
    $new_releases->execute();
    if ($new_releases->fetch())
    {
?>

<div id="new-releases" class="category">

<h1>Nieuwe releases</h1>
<?php
        do
        {
?>

<div class="product-thumb">
    <a href="item-description.php?id=<?php echo $id; ?>">
    <div class="image"><img src="<?php echo is_valid_cover($cover); ?>" /></div>
    <p class="title"><?php echo $titel; ?></p>
    <p class="price">&euro;<?php echo $prijs; ?></p>
    </a>
</div>
<?php
        } while ($new_releases->fetch());
?>

</div>
<?php
    }
    $new_releases->free_result();

    $pre_orders = $db->prepare('SELECT id, titel, prijs, release_date, cover FROM Producten WHERE release_date > CURRENT_DATE LIMIT 8');
    $pre_orders->bind_result($id, $titel, $prijs, $datum, $cover);
    $pre_orders->execute();
    if ($pre_orders->fetch())
    {
?>

<div id="preorders" class="category">

<h1>Binnenkort beschikbaar</h1>
<?php
        do
        {
?>

<div class="product-thumb preorder">
    <a href="item-description.php?id=<?php echo $id; ?>">
    <div class="image"><img src="<?php echo is_valid_cover($cover); ?>" /></div>
    <p class="title"><?php echo $titel; ?></p>
    <p class="price">&euro;<?php echo $prijs; ?></p>
    <p class="date"><?php echo $datum; ?></p>
    </a>
</div>
<?php
        } while ($pre_orders->fetch());
?>

</div>
<?php  
    }
    $pre_orders->free_result();
    
    $db->close();
?>

</div>