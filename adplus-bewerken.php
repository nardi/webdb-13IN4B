<?php
    $db = connect_to_db();
    
    
    if (isset($_REQUEST['naam']))  {
        $naam = $_POST['naam'];
        $achternaam = $_POST['achternaam'];
        $telefoonnummer = $_POST['telefoonnummer'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        $id = $_POST['id'];
        
        $sqli = $db->prepare("UPDATE Gebruikers SET naam = ?, achternaam = ?, telefoonnummer = ?, email = ?, status = ? WHERE id = ?");
        $sqli->bind_param('ssssii', $naam, $achternaam, $telefoonnummer, $email, $status, $id);
        $sqli->execute();
        
        
    
    }
    
    else {

    
        $idedit = $_POST['id'];
        
        $sqli = $db->prepare("SELECT naam, achternaam, telefoonnummer, email, status FROM Gebruikers WHERE id=?");
        $sqli->bind_param('i', $idedit);
        $sqli->bind_result($naam, $achternaam, $telefoonnummer, $email, $status);
        $sqli->execute();
                
        echo '<form method="post" action="adplus-bewerken.php">';
        
        echo "<input type='submit' name='submit' value='Wijzigingen opslaan'>";
        
        echo "<h1> Gebruikers gegevens </h1>";
        echo "<table>
            <tr>
            <td > Voornaam </td> <td> Achternaam </td> <td> Telefoonnummer </td> <td> Email </td> <td> Status </td>
            </tr>
            <hr />";
        
        
        
        while ($sqli->fetch()) {  
            echo "<tr>
            <td><input size='15' type='text' name='naam' value ='$naam' /></td>
            <td><input size='15' type='text' name='achternaam' value ='$achternaam' /></td>
            <td><input size='15' type='text' name='telefoonnummer' value ='$telefoonnummer' /></td>
            <td><input size='20' type='text' name='email' value ='$email' /></td>
            <td><select name ='status'>";
            ?>
                <option value='1' <?php if($status == 1){ echo 'selected="selected"';} ?> >Ongeverifiëerd</option>
                <option value='2' <?php if($status == 2){ echo 'selected="selected"';} ?> >Geverifiëerd</option> 
                <option value='3' <?php if($status == 3){ echo 'selected="selected"';} ?> >Medewerker</option>
                <option value='4' <?php if($status == 4){ echo 'selected="selected"';} ?> >Beheerder</option>
                </select></td>
            <?php
            echo "<td><input type='hidden' name='id' value ='$idedit' /></td>
            </tr>
        
            </table>";
        }
        
        echo "</form>";
        
        $sqli->free_result();
        $sqli = $db->prepare("SELECT id, postcode, huisnummer, toevoeging, plaats, straat FROM Adressen JOIN AdresGebruiker ON Adressen.id = adres_id WHERE gebruiker_id= ?");
        $sqli->bind_param('i', $idedit);
        $sqli-> bind_result($adres_id, $postcode, $huisnummer, $toevoeging, $plaats, $straat);
        $sqli->execute();
        
        echo "<h1> Adresgegevens gebruiker </h1>";
        
        echo "<table>
            <tr>
            <b> <td> Adres ID </td> <td> Postcode </td>  <td> Plaats </td>  <td> Straat </td> <td> Huisnummer </td> <td> Toevoeging </td></b>
            </tr>
            <hr />";
            
        
        while ($sqli->fetch()) {
            echo "<tr>
                <td>$adres_id</td><td>$postcode</td><td>$plaats</td><td>$straat</td><td>$huisnummer</td><td>$toevoeging</td>
                </tr>";
        }
        echo "</table>";
    }
    
    $db->close();
    
    
    
    
    
?>