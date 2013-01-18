<div class="clickable-item" onClick="window.open('/', '_self');">
    Beginpagina
</div>

<div class="clickable-item" onClick="window.open('products.php', '_self');">
    Producten
</div>

<div class="clickable-item" onClick="window.open('overons.php', '_self');">
    Over ons
</div>

<div class="clickable-item" onClick="window.open('overons.php#contact', '_self');">
    Contact
</div>



<?php
    if (isset($_SESSION['logged-in'])) {
        if ($_SESSION['gebruiker-status'] == 3) {
            ?>
            <hr>
            <div class="clickable-item" onClick="window.open('product-toevoegen.php', '_self');">
                Product Toevoegen
            </div>
            <div class="clickable-item" onClick="window.open('upload-test.html', '_self');">
                F-UP test
            </div>
            <?php
        }
    }
?>