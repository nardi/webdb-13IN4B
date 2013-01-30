<!-- 
In deze .php file wordt de het account van de gebruiker verwijderd.
Voor het verwijderen wordt eerst het wachtwoord nogmaals gevraagd ter bevestiging.
Na verwijdering wordt hij dus automatisch uitgelogd.
-->

<?php
    if (!isset($_SESSION['logged-in']))
    {
        echo 'U moet uiteraard ingelogd zijn om uw account te verwijderen.';
        exit();
    }
    if (!isset($_POST['wachtwoord']))
    {
        echo 'Deze pagina vereist wachtwoordverificatie.';
        exit();
    }
    
    $gebruiker_id = $_SESSION['gebruiker-id'];
    $wachtwoord = $_POST['wachtwoord'];
    
    $db = connect_to_db();
    $sql = $db->prepare("SELECT wachtwoord FROM Gebruikers WHERE id = ? LIMIT 1");
    $sql->bind_param('i', $_SESSION['gebruiker-id']);
    $sql->execute();
    $sql->bind_result($wwdb);
    $sql->fetch();
    $sql->free_result();

    if (!check_wachtwoord($wachtwoord, $wwdb))
    {
        redirect_to("wachtwoord-onjuist.html");
        $db->close();
        exit();
    }
    else {        
        $sql = $db->prepare("DELETE FROM Gebruikers WHERE id= '".$_SESSION['gebruiker-id']."' LIMIT 1");
        $sql->execute();  
        
        $sql->free_result();    
        
        if (isset($_SESSION['logged-in'])) {
            session_destroy();
        }

        redirect_to("verwijderen-succesvol.html");
        $db->close();
        exit();
    }
?>