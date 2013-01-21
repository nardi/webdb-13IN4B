

<div id="/" class="clickable-item" onClick="window.open('/', '_self');">
    Beginpagina
</div>

<div id="/products.php" class="clickable-item" onClick="window.open('products.php', '_self');">
    Producten
</div>

<div></div>

<div id="/overons.php" class="clickable-item" onClick="window.open('overons.php', '_self');">
    Over ons
</div>

<div id="/overons.php#contact" class="clickable-item" onClick="window.open('overons.php#contact', '_self');">
    Contact
</div>

<div></div>

<div>
    <form method="get" action="products.php">
        <input type="text" name="search"/>
    </form>
</div>



<?php
    if (isset($_SESSION['logged-in'])) {
        if ($_SESSION['gebruiker-status'] == 3) {
            ?>
            <hr>
            <div id="/product-toevoegen.php" class="clickable-item" onClick="window.open('product-toevoegen.php', '_self');">
                Product Toevoegen
            </div>
            <div id="/upload-test.html" class="clickable-item" onClick="window.open('upload-test.html', '_self');">
                F-UP test
            </div>
            <?php
        }
    }
?>