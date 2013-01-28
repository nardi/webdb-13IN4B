<?php
    $db = connect_to_db();

    $emailquery ='%' . $_GET['email'] . '%';
  
    $sqli = $db->prepare("SELECT naam, achternaam, email, status from Gebruikers WHERE email LIKE ? LIMIT 10");
    $sqli->bind_param('s', $emailquery);
    $sqli-> bind_result($naam, $achternaam, $email, $status);
    echo $sqli->execute();

    echo "<table>";
    
    
    while ($sqli->fetch()) {
        echo "<tr>";
        echo "<td width=80pt>$naam</td> 
            <td width=150pt>$achternaam</td> 
            <td width=250pt>$email</td> 
            <td width=10pt>$status</td>";
        echo "</tr>";
        
    }
    echo "</table>";
    $db->close();
?>
