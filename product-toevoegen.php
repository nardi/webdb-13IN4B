<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
 
<?php
	if ((!isset($_SESSION['logged-in'])) || ($_SESSION['gebruiker-status'] < 3)) {
		echo "You don't belong here!!!";
	}
	else {
		?>
		<div class="centered-container">
			<div class="product-toevoegen">
				<form action="product-toevoegen-db.php" method="post">
				  <div align="right"> 
				  <h1><center><b>Product toevoegen</b></center></h1>
					  <hr width="100%">
					  <center><b>Productspecificaties</b></center>
					  <br>
					  Titel: <input type="text" name="titel"><br>
					  Beschrijving: <input type="text" name="beschrijving"><br>
					  Prijs: <input type="text" name="prijs"><br>
					  Release date: <input type="text" name="release_date"><br>
					  Voorraad: <input type="text" name="voorraad"><br>
					  Platform:
					  <div class="platform">
		  
						  <select name="platform">
						  <option value="ps3">PS3</option>
						  <option value="ps2">PS2</option>
						  <option value="psp">PSP</option>
						  <option value="psvita">PlayStation Vita</option>
						  <option value="xbox">XBOX 360</option>
						  <option value="pc">PC</option>
						  <option value="nds">Nintendo DS</option>
						  <option value="n3ds">Nintendo 3DS</option>  
						  <option value="wiiu">Wii U</option>
						  <option value="wii">Wii</option>
						  <option value="pc">PC</option>
						  </select>

					  </div>
					  <br/>              
					  Genre:
					  <div class="genre">

						  <select name="genre">
						  <option value="actie">Actie</option>
						  <option value="race">Race</option>
						  <option value="sport">Sport</option>
						  <option value="virtueelleven">Virtueel leven</option>
						  <option value="avontuur">Avontuur</option>
						  <option value="partyenmuziek">Party & Muziek</option>
						  <option value="strat">Strategie</option>
						  </select>

					  </div>
					  <br/>
					  <div align="right">
					  
					  </div>
					  <input type="submit" value="Voeg product toe">
				  </div>
				</form>
			</div>
		</div>
		<?php
		}
		?>