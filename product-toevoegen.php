<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
 
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
				<form action="product-toevoegen-db.php" method="post" enctype="multipart/form-data">
				  <div align="right"> 
				  <h1><center><b>Product toevoegen</b></center></h1>
					  <hr width="100%">
					  <center><b>Productspecificaties</b></center>
					  <br />
					  Titel: <input type="text" name="titel"><br /> <br />
					  Beschrijving:
					  <textarea rows="5" cols="20" name="beschrijving"></textarea>
					  <br />  
					  Prijs: <input type="text" name="prijs"><br />
					  Release date: <input type="text" name="release_date"><br />
					  Voorraad: <input type="text" name="voorraad"><br />
					  Platform:
					  <div class="platform">
                          <select name="platform">
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
					  </div>
					  <br/>              
					  Genre:
					  <div class="genre">

						  <select name="genre" onchange="alert('fyes, bacon!');">
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

					  </div>
					  <br/>
                      
                      <!-- Image upload to db test -->
                      <div>
                      Cover: 
                      <input type="file" name="image" />
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