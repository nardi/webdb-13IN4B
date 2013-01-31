<!-- De Sidebar bevat alle knoppen die zich in de sidebar bevinden -->
<!-- De volgende knoppen zijn zichtbaar voor iedereen -->
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

<!-- Klantenservice is alleen zichtbaar voor ingelogde gebruikers. -->

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

<!-- De zoekfunctie en bijbehorende submit knop. -->

<form method="get" action="products.php" id='searchform'>
    <div id='searchcontainer'>
        <input type="text" name="search" id='searchbar'/>
        <div id='searchbutton' onclick="document.getElementById('searchform').submit()">
        </div>
    </div>
</form>


<!-- De volgende knoppen zijn alleen beschikbaar voor medewerkers. (Status 3 of hoger in de database.) -->

<?php
    if (isset($_SESSION['logged-in'])) {
        if (is_admin()) {
            ?>
            <br /> <hr />
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
        
        /* Deze knop is alleen toegankelijk voor de beheerders. (Level 4 of hoger in de database)
         */
        
        if (is_owner()) {
        ?>
            <br /> <hr />
            <div id="adplus.php" class="clickable-item" onclick="onButtonclick(this.id);">
                Gebruikers
            </div>
            <?php
        }
    }
?>