<?php
    
    if (is_admin())
    {
    
        $db = connect_to_db();
        
        
        if (isset($_REQUEST['prijs']))  {
            $prijs = $_POST['prijs'];
            $start_datum = $_POST['start_datum'];
            $eind_datum = $_POST['eind_datum'];
            $id = $_POST['id'];
            
            $sqli = $db->prepare("UPDATE Aanbiedingen SET prijs = ?, start_datum = ?, eind_datum = ? WHERE id = ?");
            $sqli->bind_param('dssi', $prijs, $start_datum, $eind_datum, $id);
            $sqli->execute();
        }
        
        else {
        
            $idedit = $_POST['id'];
            
            $db = connect_to_db();
                
            $sqli = $db->prepare('SELECT titel, Producten.prijs, Aanbiedingen.prijs, start_datum, eind_datum FROM Producten JOIN Aanbiedingen ON product_id = Producten.id WHERE Producten.id = ?');
            $sqli->bind_param('i', $idedit);
            $sqli->bind_result($titel, $oude_prijs, $prijs, $start_datum, $eind_datum);
            $sqli->execute();
            
                    
            echo '<form method="post" action="aanbieding-bewerken.php">';
            
            echo "<input type='submit' name='submit' value='Wijzigingen opslaan'> <br />";
            
             
            
            $sqli->fetch();
            echo "<tr>
            <td><input size='15' type='text' name='titel' disabled='disabled' value ='$titel' /></td>
            <td><input size='15' type='text' name='oude_prijs' disabled='disabled' value ='$oude_prijs' /></td>
            <td><input size='15' type='text' name='prijs' value ='$prijs' /></td>
            <td><input size='20' type='text' name='start_datum' value ='$start_datum' /></td>
            <td><input size='20' type='text' name='eind_datum' value ='$eind_datum' /></td>
            <td><input type='hidden' name='id' value ='$idedit' />
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