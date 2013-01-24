<div id="frontpage">
<?php
    $db = connect_to_db();
?>

<div id="on-sale" class="category">

<h1>In de aanbieding</h1>

<div class="product-hilite">
    <a href="item-description.php?id=1">
    <img src="images/products/1.jpg" />
    <div id="desc" class="vcenter-container">
        <div class="vcenter">
            <p class="title">Battletoads</p>
            <p>van</p>
            <p class="old-price">&euro;42,-</p>
            <p>voor</p>
            <p class="price">&euro;13,37</p>
        </div>
    </div>
    </a>
</div>

<div class="product-hilite">
    <a href="item-description.php?id=1">
    <img src="images/products/1.jpg" />
    <div id="desc" class="vcenter-container">
        <div class="vcenter">
            <p class="title">Battletoads</p>
            <p>van</p>
            <p class="old-price">&euro;42,-</p>
            <p>voor</p>
            <p class="price">&euro;13,37</p>
        </div>
    </div>
    </a>
</div>

<div class="product-hilite">
    <a href="item-description.php?id=1">
    <img src="images/products/1.jpg" />
    <div id="desc" class="vcenter-container">
        <div class="vcenter">
            <p class="title">Battletoads</p>
            <p>van</p>
            <p class="old-price">&euro;42,-</p>
            <p>voor</p>
            <p class="price">&euro;13,37</p>
        </div>
    </div>
    </a>
</div>

</div>
<?php
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
    <img src="<?php echo is_valid_cover($cover); ?>" />
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
    <img src="<?php echo is_valid_cover($cover); ?>" />
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