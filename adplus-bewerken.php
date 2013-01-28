<?php
    $db = connect_to_db();
    
    $idedit = $_POST['id'];
    
    $sqli = $db->prepare("SELECT naam, achternaam, telefoonnummer, email, status FROM Gebruikers WHERE id=?");
    $sqli->bind_param('i', $idedit);
    $sqli->bind_result($naam, $achternaam, $telefoonnummer, $email, $status);
    echo $sqli->execute();
    echo $naam . "...<br />";
    
    echo "<h1> Gebruikers gegevens </h1>";
    echo "<table>
        <tr>
        <b> <td> Voornaam </td> <td> Achternaam </td> <td> Telefoonnummer </td> <td> Email </td> <td> Status </td> </b>
        </tr>
        
        <tr>
        <td>$naam</td><td>$achternaam</td><td>$telefoonnummer</td><td>$email</td><td>$status</td>
        </tr>
    
        </table>";
    
    
   /* $sqli->free_result();
    $sqli = $db->prepare("SELECT id, postcode, huisnummer, toevoeging, plaats, straat FROM Adressen JOIN AdresGebruiker ON Adressen.id = adres_id WHERE gebruiker_id= ?");
    $sqli->bind_param('i', $idedit);
    $sqli-> bind_result($adres_id, $postcode, $huisnummer, $toevoeging, $plaats, $straat);
    $sqli->execute();
    
    echo "<h1> Adresgegevens gebruiker </h1>";
    
    echo "<table>
        <tr>
        <b> <td> Adres ID </td> <td> Postcode </td>  <td> Plaats </td>  <td> Straat </td> <td> Huisnummer </td> <td> Toevoeging </td></b>
        </tr>";
  
    
    while ($sqli->fetch()) {
        echo "<tr>
            <td>$adres_id</td><td>$postcode</td><td>$plaats</td><td>$straat</td><td>$huisnummer</td><td>$toevoeging</td>
            </tr>
            </table>";
    }
    */
    $db->close();
    
?>