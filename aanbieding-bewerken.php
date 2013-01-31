<?php
    /* Door deze check wordt, m.b.v. main.php gekeken of de gebruiker de juiste privileges heeft.
     */
    if (is_admin())
    {
    
        $db = connect_to_db();
        
        /* Als prijs is ge-post, dan betekent het dat een aanbieding is aangepast en dat deze naar de database
         * moet worden gestuurd. Dat wordt gedaan met het volgende stukje code.
         */
        if (isset($_REQUEST['prijs']))  {
            $prijs = $_POST['prijs'];
            $start_datum = $_POST['start_datum'];
            $eind_datum = $_POST['eind_datum'];
            $id = $_POST['id'];
            
            echo $id;
            $sqli = $db->prepare("UPDATE Aanbiedingen SET prijs = ?, start_datum = ?, eind_datum = ? WHERE id = ?");
            $sqli->bind_param('dsss', $prijs, $start_datum, $eind_datum, $id);
            $sqli->execute();
        }
        
        /* Zo niet, dan wil de medewerker een aanbieding aanpassen.  Dat wordt hier gedaan.
         */
        else {
        
            $idedit = $_POST['id'];
            
            
            /* De gegevens van het te bewerken product worden uit de database geladen.
             */
            $sqli = $db->prepare('SELECT titel, Producten.prijs, Aanbiedingen.prijs, start_datum, eind_datum, Aanbiedingen.id
                    FROM Producten JOIN Aanbiedingen ON product_id = Producten.id WHERE Producten.id = ?');
            $sqli->bind_param('i', $idedit);
            $sqli->bind_result($titel, $oude_prijs, $prijs, $start_datum, $eind_datum, $aanbieding_id);
            $sqli->execute();
            
            /* Er wordt een form aangemaakt met daarin de waardes van de aanbieding.
             * Sommige velden, zoals de standaard prijs en titel, kunnen niet worden aangepast.
             * Dit omdat deze, voor een aanbieding, niet aangepast zouden moeten kunnen worden.
             */
            echo '<form method="post" action="aanbieding-bewerken.php">';
            
            echo "<input type='submit' name='submit' value='Wijzigingen opslaan'> <br />";
                       
            $sqli->fetch();
            echo "<tr>
            <td><input size='15' type='text' name='titel' disabled='disabled' value ='$titel' /></td>
            <td><input size='15' type='text' name='oude_prijs' disabled='disabled' value ='$oude_prijs' /></td>
            <td><input size='15' type='text' name='prijs' value ='$prijs' /></td>
            <td><input size='20' type='text' name='start_datum' value ='$start_datum' /></td>
            <td><input size='20' type='text' name='eind_datum' value ='$eind_datum' /></td>
            <td><input type='hidden' name='id' value ='$aanbiedingen_id' />
            </tr>
        
            </table>";
            
            echo "</form>";
            
        }
        
        $db->close();
    }
    
    else{
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
    }
?>