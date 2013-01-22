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
        echo 'Het opgegeven wachtwoord is niet juist.';
        $db->close();
        exit();
    }
    else {        
        $sql = $db->prepare("DELETE FROM Gebruikers WHERE id= '".$_SESSION['gebruiker-id']."' LIMIT 1");
        $sql->execute();  
        
        if (!$sql->fetch()) { print "Onverwachte fout: Geen data."; exit(); }
        $sql->free_result();

        $sql = $db->prepare("DELETE FROM Adressen JOIN AdresGebruiker ON Adressen.id = adres_id WHERE gebruiker_id= '".$_SESSION['gebruiker-id']."' LIMIT 1");
        $sql->execute();   

        if (!$sql->fetch()) { print "Onverwachte fout: Geen data."; exit(); }
        $sql->free_result();
        
        echo 'U heeft succesvol uw account verwijderd.';
        $db->close();
        exit();
    }
?>