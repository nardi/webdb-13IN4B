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

<?php
	if (isset($_SESSION['logged-in'])) {
		?>
		<div id="klantenservice.php" class="clickable-item" onclick="onButtonclick(this.id);">
			Klantenservice
		</div>
		<?php
	}
?>

<div></div>

<form method="get" action="products.php" id='searchform'>
    <div id='searchcontainer'>
        <input type="text" name="search" id='searchbar'/>
        <div id='searchbutton' onclick="document.getElementById('searchform').submit()">
        </div>
    </div>
</form>

<?php
    if (isset($_SESSION['logged-in'])) {
        if (is_admin()) {
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
            
            <div id="aanbiedingen.php" class="clickable-item" onclick="onButtonclick(this.id);">
                Aanbiedingen
            </div>
            
        <?php    
        }
        if (is_owner()) {
        ?>
        
            <div id="adplus.php" class="clickable-item" onclick="onButtonclick(this.id);">
                Gebruikers
            </div>
            
            <div id="upload-test.html" class="clickable-item" onclick="onButtonclick(this.id);">
                F-UP test
            </div>
            <?php
        }
    }
?>