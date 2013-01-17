<div class="clickable-item" onClick="window.open('/', '_self');">
    Beginpagina
</div>

<div class="clickable-item" onClick="window.open('category.php', '_self');">
    Categoriën
</div>

<div class="clickable-item" onClick="window.open('overons.php', '_self');">
    Over ons
</div>

<div class="clickable-item" onClick="window.open('overons.html#contact', '_self');">
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
            <div class="clickable-item" onClick="window.open('filetest.html', '_self');">
                F-UP test
            </div>
            <?php
        }
    }
?>