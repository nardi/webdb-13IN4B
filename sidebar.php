<div class="clickable-item" onClick="window.open('/', '_self');">
    Beginpagina
</div>
<div class="clickable-item" onClick="window.open('overons.html', '_self');">
    Over ons
</div>
<div class="clickable-item" onClick="window.open('overons.html#contact', '_self');">
    contact
</div>
<div class="clickable-item" onClick="window.open('wachtwoordvergeten.html', '_self');">
    Wachtwoord vergeten
</div>
<div class="clickable-item" onClick="window.open('item-description.html', '_self');">
    Productbeschrijving
</div>
<div class="clickable-item" onClick="window.open('category.php', '_self');">
    Categorie
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