<?php
    function product_thumb($id, $cover, $titel, $prijs, $aanbiedingsprijs = null, $datum = null)
    {
?>
<div class="product-thumb<?php if ($datum !== null) { ?> preorder<?php } ?>">
    <div class="image"><a href="item-description.php?id=<?php echo $id; ?>"><img src="<?php echo $cover; ?>" alt="Cover"/></a></div>
    <p class="title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars($titel); ?></a></p>
    <p><a href="item-description.php?id=<?php echo $id; ?>">
<?php if ($aanbiedingsprijs !== null) { ?>
        <span class="old-price">&euro;<?php echo prijs_opmaak($prijs); ?></span><br />
        <span class="price">&euro;<?php echo prijs_opmaak($aanbiedingsprijs); ?></span>
<?php } else { ?>
        <span class="price">&euro;<?php echo prijs_opmaak($prijs); ?></span>
<?php } ?>
    </a></p>
    <?php if ($datum !== null) { ?><p class="date"><?php echo $datum; ?></p><?php } ?>
</div>
<?php
    }
?>