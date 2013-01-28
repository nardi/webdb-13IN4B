<div id="/" class="clickable-item" onClick="onButtonClick(this.id);">
    Beginpagina
</div>

<div id="/products.php" class="clickable-item" onClick="onButtonClick(this.id);">
    Producten
</div>

<div></div>

<div id="/overons.html" class="clickable-item" onClick="onButtonClick(this.id);">
    Over ons
</div>

<div id="/contact.html" class="clickable-item" onClick="onButtonClick(this.id);">
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
        if ($_SESSION['gebruiker-status'] >= 3) {
            ?>
            <hr>
            <div id="/bestellingsoverzicht.php" class="clickable-item" onClick="onButtonClick(this.id);">
                Bestellingsoverzicht
            </div>
            
            <div id="/product-toevoegen.php" class="clickable-item" onClick="onButtonClick(this.id);">
                Product toevoegen
            </div>
            
            <div id="/producten-beheren.php" class="clickable-item" onClick="onButtonClick(this.id);">
                Producten beheren
            </div>
            
            <div id="/aanbieding-toevoegen.php" class="clickable-item" onClick="onButtonClick(this.id);">
                Aanbieding toevoegen
            </div>
            
            <div id="/upload-test.html" class="clickable-item" onClick="onButtonClick(this.id);">
                F-UP test
            </div>
            <?php
        }
    }
?>