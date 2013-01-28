<?php
    $db = connect_to_db();

    $emailquery = $_GET['email'];

    $sqli = $db->prepare("SELECT naam, achternaam, email from Gebruikers WHERE email LIKE ? LIMIT 10");
    $sqli->bind_param('s', $emailquery);
    $sqli-> bind_result($naam, $achternaam, $email);
    echo $sqli->execute();

    echo "<table>";
    
    
    while ($sqli->fetch()) {
        echo "<tr>";
        echo "<td>$naam</td> <td>$achternaam</td> <td>$email</td>";
        echo "</tr>";
        
    }
    echo "</table>";
    $db->close();
?>
