<div class="centered-container">

    <?php
        /* Door deze check wordt, m.b.v. main.php gekeken of de gebruiker de juiste privileges heeft.
         */
        if (is_admin())
        {
            
            /* Gebruik de onderstaande link om naar de pagina te gaan waar je een nieuwe aanbieding kunt maken
             */
            echo "<h1>Aanbieding toevoegen:</h1>";
            echo '<a href="aanbieding-toevoegen.php">Klik hier om een aanbieding toe te voegen</a>';
            echo "<br /> <hr />";
            
            $db = connect_to_db();
            

            /* Alle huidige en toekomstige aanbiedingen worden hier opgehaald uit de database.
             */
            $on_sale = $db->prepare('SELECT Producten.id, titel, Producten.prijs, Aanbiedingen.prijs, start_datum, eind_datum 
                            FROM Producten JOIN Aanbiedingen ON product_id = Producten.id WHERE eind_datum >= CURRENT_DATE');
            $on_sale->bind_result($id, $titel, $oude_prijs, $prijs, $start_datum, $eind_datum);
            $on_sale->execute();
            
            echo "<h1>Aanbiedingen:</h1>";
            
            /* Deze worden in een form gezet, met naast elke aanbieding een knop om deze te bewerken.
             * Deze knop redirect naar de aanbieding-bewerken pagina
             */
            echo "<form action='aanbieding-bewerken.php' method='post'>
                  <table>
                  <tr>
                  <th>Spel</th> <th>Oude prijs</th> <th>Aanbiedingsprijs</th> <th>Start Datum</th> <th>Eind Datum</th>       
                  </tr>";
            
                while($on_sale->fetch()) {
                    echo "<tr>";
                    echo "<td>$titel</td> <td>$oude_prijs</td> <td>$prijs</td> <td>$start_datum</td> <td>$eind_datum</td>";
                    echo "<td><button name=\"id\" type=\"submit\" value=\"$id\">Bewerken</button></td>";
                    echo "</tr>";
                }
                
            echo "</table> </form>";
            
            echo "<hr /> <br />";
            
            $on_sale->free_result();
            
            
            /* De volgende query laad alle verlopen aanbiedingen uit de database, zodat deze ook bewerkt en eventueel
             * herbuikt kunnen worden. Verder werkt het hetzelfde als met huidige aanbiedingen.
             */
            $on_sale = $db->prepare('SELECT Producten.id, titel, Producten.prijs, Aanbiedingen.prijs, start_datum, eind_datum 
                        FROM Producten JOIN Aanbiedingen ON product_id = Producten.id WHERE eind_datum < CURRENT_DATE');
                        
            $on_sale->bind_result($id, $titel, $oude_prijs, $prijs, $start_datum, $eind_datum);
            $on_sale->execute();
            
            echo "<h1>Verlopen aanbiedingen:</h1>";
            
            echo "<form action='aanbieding-bewerken.php' method='post'>
                  <table class='verlopen'>
                  <tr>
                  <th>Spel</th> <th>Oude prijs</th> <th>Aanbiedingsprijs</th> <th>Start Datum</th> <th>Eind Datum</th>       
                  </tr>";
            
                while($on_sale->fetch()) {
                    echo "<tr>";
                    echo "<td>$titel</td> <td>$oude_prijs</td> <td>$prijs</td> <td>$start_datum</td> <td>$eind_datum</td>";
                    echo "<td><button name=\"id\" type=\"submit\" value=\"$id\">Bewerken</button></td>";
                    echo "</tr>";
                }
                
            echo "</table> </form>";
            
            
            
            $db->close();
        }
        else{
            throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
        }
    ?>
    
</div>