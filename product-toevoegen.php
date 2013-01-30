<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
<script src="productToevoegen.js"></script>

<?php
	if (!is_admin()) {
	?>
	<pre>


            _.._
           (_.-.\
       .-,       `
  .--./ /     _.-""-.
   '-. (__..-"       \
      \          a    |
       ',.__.   ,__.-'/
         '--/_.'----'`
Whale, whale, whale. What do we have here?		
	</pre>
	<?php
	}
	else {
        

        $db = connect_to_db();
?>
		<div class="centered-container">
			<div class="product-toevoegen">
				<form method="post" enctype="multipart/form-data" onsubmit="testall()" action="javascript:void(0)">
				  <div align="right"> 
				  <h1><center><b>Product toevoegen</b></center></h1>
					  <hr width="100%">
					  <center><b>Productspecificaties</b></center>
					  <br />
					  Titel: <input type="text" id="titel" name="titel"><div id='titellabel' class='label' onblur="checkTekst('titel','titellabel')"></div><br /> <br />
					  Beschrijving:
					  <textarea rows="5" cols="20" id="beschrijving" name="beschrijving"></textarea><div id='beschrijvinglabel' class='label' onblur="checkTekst('beschrijving','beschrijvinglabel')"></div>
					  <br />  
					  Prijs: <input type="text" id="prijs" name="prijs"><div id='prijslabel' class='label' onblur="checkPrijs('prijs', 'prijslabel')"></div><br />
					  Release date: <input type="text" id="release_date" name="release_date"><div id='releaselabel' class='label'onblur="checkDatum('release_date','releaselabel')"></div><br />
					  Voorraad: <input type="text" id="voorraad" name="voorraad"><div id='voorraadlabel' class='label' onblur="checkPrijs('voorraad','voorraadlabel')"></div><br />
					  Platform:
					  <div class="platform">
                          <select name="platform" id="platform" onchange="checkDropdown('platform','platformlabel')">
                          <option value="" selected='selected'>
<?php
        $platformsql = $db->prepare("SELECT id, naam FROM Platforms");
        $platformsql->execute();
        $platformsql->bind_result($platformid, $platform);

        while ($platformsql->fetch()) {
?>
						  <option value="<?php echo $platformid; ?>"><?php echo $platform; ?></option>
<?php
        }
        
        $platformsql->free_result();
?>
+						  </select>
					  </div><div id="platformlabel" class='label'></div>
					  <br/>              
					  Genre:
					  <div class="genre">
						  <select name="genre" id="genre" onchange="checkDropdown('genre','genrelabel')">
                          <option value="" selected='selected'>
<?php
        $genresql = $db->prepare("SELECT id, naam FROM Genres");
        $genresql->execute();
        $genresql->bind_result($genreid, $genre);

        while ($genresql->fetch()) {
?>
						  <option value="<?php echo $genreid; ?>" ><?php echo $genre; ?></option>
<?php
        }
        
        $genresql->free_result();
        $db->close();
?>
						  </select>

					  </div><div id='genrelabel' class='label'></div>
					  <br/>
                      
                      <!-- Image upload to db test -->
                      <div>
                      Cover: 
                      <input type="file" name="image" id="image" onchange="checkCover('image','coverlabel')" /><div id='coverlabel' class='label'></div>
					  </div>
                      
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