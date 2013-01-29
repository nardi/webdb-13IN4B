<link rel="stylesheet" type="text/css" href="producten-beheren.css">
<script src="productenBeheren.js"></script>

<?php
    $db = connect_to_db();
    
    $sqli_product_lijst = $db->prepare("SELECT Producten.id,titel,platform_id,genre_id,beschrijving,prijs,release_date,voorraad,datum_toegevoegd,cover,Platforms.naam,Genres.naam FROM Producten JOIN Platforms ON platform_id=Platforms.id JOIN Genres ON genre_id=Genres.id");
    $sqli_product_lijst->bind_result($id,$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$datum_toegevoegd,$cover,$platformnaam,$genrenaam);
    $sqli_product_lijst->execute();
    $sqli_product_lijst->store_result();
    
?>
<div id="BeheerContainer">
<form name='EditProduct' id='EditProductId$id' action='verander-product.php' method='post' enctype='multipart/form-data'>
<table id="Producten">
<tr><th>Aanpassen</th><th colspan="2">Verwijderen</th><th>Product Nummer</th><th>Titel</th><th>Cover</th><th>Beschrijving</th><th>Platform</th><th>Genre</th><th>Prijs</th><th>Voorraad</th><th>Release Datum</th></tr>
<tr><td colspan=12>
<hr />
</td></tr>
    <?php
        $db2 = connect_to_db();
        $db3 = connect_to_db();
            
        while($sqli_product_lijst->fetch()) {
            $cover = is_valid_cover($cover);
            $cover_var = "<img src='".$cover."' />";
            $titelwidth = strlen($titel);
            $beschrijvingSizeRaw = strlen($beschrijving)/30;
            $beschrijvingSize = ceil($beschrijvingSizeRaw);
            echo "
            <tr id=$id>
                <td>
                    <input type='submit' value='submit'>
                </td>
                <td>
                    <div class='ProductEdit' onclick='enableEdit($id)'>
                    </div>
                </td>
                <td>
                    <div class='ProductDelete'>
                            <!--<form name='ActuallyAButton' id='DeleteItem' action='product-verwijderen.php' method='post'>
                                <input type='hidden' name='delete' value='$id'>
                                <input type='submit' value='' name='submitButton' class='DeleteSubmitButton'>
                            </form>-->
                    </div>
                </td>
                <td><input type='checkbox' name='selected'></td>
                <td class='column'>$id</td>
                <td>
                    <input type='text' value=$id hidden='hidden' name='idee$id'>
                </td>
                <td class='column'><input type='text' class='inputfield' name='titel' disabled='disabled' value='$titel' size=$titelwidth>titel$id</td>
                <td class='column'><div class='cover' id='cover$id' onclick=\"showImage(cover$id, '$cover')\">Klik hier om de cover te laten zien.</div></td>
                <td class='column'><textarea class='inputfield' id='beschrijvingid$id' name='beschrijving' disabled='disabled' cols='30' rows='1' onclick='expand(beschrijvingid$id, $beschrijvingSize)' onblur='shrink(beschrijvingid$id)'>$beschrijving</textarea></td>
                <td><div class='platform'>
                    <select name='platform' disabled='disabled'>";

        $platformsql = $db->prepare("SELECT id, naam FROM Platforms");
        $platformsql->execute();
        $platformsql->bind_result($platformid, $platform);

            while ($platformsql->fetch()) {
                            ?>
                              <option value=<?php echo"'$platformid'";?> <?php if($platformid==$platform_id){ echo "selected='selected'";}?>><?php echo "$platform";?> </option>

            <?php }
        
        $platformsql->free_result();
                echo "
						  </select>
					  </div></td>
                      
                      <td><div class='genre'>
                    <select name='genre' disabled='disabled'>";

        $genresql = $db->prepare("SELECT id, naam FROM Genres");
        $genresql->execute();
        $genresql->bind_result($genreid, $genre);

            while ($genresql->fetch()) {
                            ?>
                              <option value=<?php echo"'$genreid'";?> <?php if($genreid==$genre_id){ echo "selected='selected'";}?>><?php echo "$genre";?> </option>

            <?php }
        
        $genresql->free_result();
                echo "
						  </select>
					  </div></td>
                <td class='column'><input type='text' class='inputfield' name='prijs' disabled='disabled' value=$prijs size='6'></td>
                <td class='column'><input type='text' class='inputfield' name='voorraad' disabled='disabled' value=$voorraad size='5'></td>
                <td class='column'><input type='text' class='inputfield' name='release' disabled='disabled' value='$release_date' size='8'></td>
            </tr>
            <tr><td colspan=12>
            <hr />
            </td></tr>
            ";
        }
    ?>
    </table>
    </form>
</div>