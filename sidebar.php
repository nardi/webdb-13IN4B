<!-- <div id="/" class="clickable-item" onClick="window.open('/', '_self');"> -->
<div id="/" class="clickable-item" onClick="onButtonClick(this.id);">
    Beginpagina
</div>

<!-- <div id="producten" class="clickable-item" onClick="window.open('products.php', '_self');"> -->
<div id="products.php" class="clickable-item" onClick="onButtonClick(this.id);">
    Producten
</div>

<div></div>

<!-- <div id="overons" class="clickable-item" onClick="window.open('overons.php', '_self');"> -->
<div id="overons.php" class="clickable-item" onClick="onButtonClick(this.id);">
    Over ons
</div>

<!-- <div id="contact" class="clickable-item" onClick="window.open('overons.php#contact', '_self');"> -->
<div id="overons.php#contact" class="clickable-item" onClick="onButtonClick(this.id);">
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
            <!-- <div id="producttoevoegen" class="clickable-item" onClick="window.open('product-toevoegen.php', '_self');"> -->
            <div id="product-toevoegen.php" class="clickable-item" onClick="onButtonClick(this.id);">
                Product Toevoegen
            </div>
            <!-- <div id="f-up" class="clickable-item" onClick="window.open('upload-test.html', '_self');"> -->
            <div id="upload-test.html" class="clickable-item" onClick="onButtonClick(this.id);">
                F-UP test
            </div>
            <?php
        }
    }
?>