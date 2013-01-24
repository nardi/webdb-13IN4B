<link rel="stylesheet" type="text/css" href="producten-beheren.css">
<script src="productenBeheren.js"></script>

<?php
    $db = connect_to_db();
    
    $sqli_product_lijst = $db->prepare("SELECT Producten.id,titel,platform_id,genre_id,beschrijving,prijs,release_date,voorraad,datum_toegevoegd,cover,Platforms.naam,Genres.naam FROM Producten JOIN Platforms ON platform_id=Platforms.id JOIN Genres ON genre_id=Genres.id");
    $sqli_product_lijst->bind_result($id,$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$datum_toegevoegd,$cover,$platformnaam,$genrenaam);
    $sqli_product_lijst->execute();
    
    
?>
<div id="BeheerContainer">
<table id="Producten">
<tr><th>Aanpassen</th><th colspan="2">Verwijderen</th><th>Product Nummer</th><th>Titel</th><th>Cover</th><th>Platform</th><th>Genre</th><th>Prijs</th><th>Voorraad</th>


    <form name='EditProduct' id='EditProductId' onsubmit='verander-product.php' method='post'>
    <input type='submit' value='wijzigingen aanbrengen'>
    <?php
        $db2 = connect_to_db();
        $db3 = connect_to_db();
        $titelwidth = strlen($titel);    
        while($sqli_product_lijst->fetch()){
            $cover_var = '<img src="'.$imagedir.$cover.'"/>';
            echo "<tr id=$id>
                <td>
                    <div class='ProductEdit' onclick='enableEdit($id)'>
                    </div>
                </td>
                <td>
                    <div class='ProductDelete>
                            <form name='ActuallyAButton' id='DeleteItem' action='product-verwijderen.php' method='post'>
                                <input type='hidden' name='delete' value='$id'>
                                <input type='submit' value='' name='submitButton' class='DeleteSubmitButton'>
                            </form>
                    </div>
                </td>
                <td><input type='checkbox' name='selected$id'></td>
                <td class='column'>$id</td>
                <td class='column'><input type='text' class='inputfield' name='titel$id' disabled='disabled' value='$titel' size=$titelwidth></td>
                <td class='column'><div class='cover' value=$cover_var></td></div>
                <div class='platform'>
                          <select name='platform'>";

        $platformsql = $db->prepare("SELECT id, naam FROM Platforms");
        $platformsql->execute();
        $platformsql->bind_result($platformid, $platform);

        while ($platformsql->fetch()) {
                        echo "
						  <option value='$platformid'; ?>><?php echo $platform; ?></option>";

        }
        
        $platformsql->free_result();
                echo "
						  </select>
					  </div></td>
                <td class='column'><input type='text' class='inputfield' name='genre$id' disabled='disabled' value=$genrenaam size='10'></td>
                <td class='column'><input type='text' class='inputfield' name='prijs$id' disabled='disabled' value=$prijs size='6'></td>
                <td class='column'><input type='text' class='inputfield' name='voorraad$id' disabled='disabled' value=$voorraad size='5'></td>
                
            </tr>";
        }
    ?>
    </form>
    </table>
    <input type='submit' value='wijzigingen aanbrengen'>
</div>