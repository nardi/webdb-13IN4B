<?php
    require_once '../main.php'; 
    $db = connect_to_db();

    $emailquery ='%' . $_GET['email'] . '%';
  
    $sqli = $db->prepare("SELECT id, naam, achternaam, email, status from Gebruikers WHERE email LIKE ? LIMIT 10");
    $sqli->bind_param('s', $emailquery);
    $sqli-> bind_result($id, $naam, $achternaam, $email, $status);
    $sqli->execute();
    echo "<form method=\"post\" action=\"adplus-bewerken.php\">";
    echo "<table>";
    
    
    while ($sqli->fetch()) {
        echo "<tr>";
        echo "<td width=80pt>$naam</td> 
            <td width=150pt>$achternaam</td> 
            <td width=250pt>$email</td> 
            <td width=10pt>$status</td>
            <td>
            <button name=\"id\" type=\"submit\" value=\"$id\">Bewerken</button>
            </td>";
            
        echo "</tr>";
        
    }
    echo "</table>";
    echo "</form>";
    $db->close();
?>
