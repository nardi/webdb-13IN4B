<div class="centered-container">

    <?php
        
        echo '<a href="aanbieding-toevoegen.php">Klik hier om een aanbieding toe te voegen</a>';
        echo "<br /> <hr />";
        
        $db = connect_to_db();
            
        $on_sale = $db->prepare('SELECT Producten.id, titel, Producten.prijs, Aanbiedingen.prijs, start_datum, eind_datum FROM Producten JOIN Aanbiedingen ON product_id = Producten.id WHERE eind_datum >= CURRENT_DATE');
        $on_sale->bind_result($id, $titel, $oude_prijs, $prijs, $start_datum, $eind_datum);
        $on_sale->execute();
        echo "<form action='aanbieding-bewerken.php' method='post'>
              <table>
              <tr>
              <td>Spel</td> <td>Oude prijs</td> <td>Aanbiedingsprijs</td> <td>Start Datum</td> <td>Eind Datum</td>       
              </tr>";
        
            while($on_sale->fetch()) {
                echo "<tr>";
                echo "<td>$titel</td> <td>$oude_prijs</td> <td>$prijs</td> <td>$start_datum</td> <td>$eind_datum</td>";
                echo "<td><button name=\"id\" type=\"submit\" value=\"$id\">Bewerken</button></td>";
                echo "</tr>";
            }
            
        echo "</table> </form>";
        $db->close();        
        
    ?>
    
</div>