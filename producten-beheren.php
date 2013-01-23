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
<tr><th>Geslecteerd</th><th>Product Nummer</th><th>Titel</th><th>Cover</th><th>Platform</th><th>Genre</th><th>Prijs</th><th>Voorraad</th>


    <form name='EditProduct' id='EditProductId' onsubtmit='verander-product.php' method='post'>
    <?php
        $db2 = connect_to_db();
        $db3 = connect_to_db();
            
        while($sqli_product_lijst->fetch()){
            $cover_var = '<img src="'.$imagedir.$cover.'"/>';
            echo "<tr id=$id>
                <td><input type='checkbox' name='selected'></td>
                <td class='column'><input type='text' class='inputfield' name='product_nummer' disabled='disabled' value=$id></td>
                <td class='column'><input type='text' class='inputfield' name='titel' disabled='disabled' value=$titel rows='3'></td>
                <td class='column'><div class='cover' value=$cover_var></td></div>
                <td class='column'><input type='text' class='inputfield' name='platform' disabled='disabled' value=$platformnaam></td>
                <td class='column'><input type='text' class='inputfield' name='genre' disabled='disabled' value=$genrenaam></td>
                <td class='column'><input type='text' class='inputfield' name='prijs' disabled='disabled' value=$prijs></td>
                <td class='column'><input type='text' class='inputfield' name='voorraad' disabled='disabled' value=$voorraad></td>
                <td>
                    <div class='ProductEdit' onclick='EnableEdit($id)'>
                    </div>
                </td>
                <td>
                    <div class='ProductDelete>
                            <input type='hidden' name='delete' value='$id'>
                            <input type='submit' value='' name='submitButton' class='DeleteSubmitButton'.$id>
                    </div>
                </td>
            </tr>";
        }
    ?>
    </form>
    </table>
</div>