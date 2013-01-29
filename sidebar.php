<div id="frontpage.php" class="clickable-item" onclick="onButtonclick();">
    Beginpagina
</div>

<div id="products.php" class="clickable-item" onclick="onButtonclick(this.id);">
    Producten
</div>

<div></div>

<div id="overons.html" class="clickable-item" onclick="onButtonclick(this.id);">
    Over ons
</div>

<div id="contact.html" class="clickable-item" onclick="onButtonclick(this.id);">
    Contact
</div>

<div></div>

<form method="get" action="products.php" id='searchform'>
    <div>
        <input type="text" name="search"/>
        <div id='searchbutton' onclick='document.getElementById('searchform').submit()'>
        </div>
    </div>
</form>

<?php
    if (isset($_SESSION['logged-in'])) {
        if ($_SESSION['gebruiker-status'] >= 3) {
            ?>
            <hr>
            <div id="bestellingsoverzicht.php" class="clickable-item" onclick="onButtonclick(this.id);">
                Bestellingsoverzicht
            </div>
            
            <div id="product-toevoegen.php" class="clickable-item" onclick="onButtonclick(this.id);">
                Product toevoegen
            </div>
            
            <div id="producten-beheren.php" class="clickable-item" onclick="onButtonclick(this.id);">
                Producten beheren
            </div>
            
            <div id="aanbieding-toevoegen.php" class="clickable-item" onclick="onButtonclick(this.id);">
                Aanbieding toevoegen
            </div>
            
            <div id="adplus.html" class="clickable-item" onclick="onButtonclick(this.id);">
                Adplus
            </div>
            
            <div id="upload-test.html" class="clickable-item" onclick="onButtonclick(this.id);">
                F-UP test
            </div>
            <?php
        }
    }
?>