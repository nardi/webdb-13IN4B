<link rel="stylesheet" type="text/css" href="succesvol.css" />

<div class="registratie-succesvol-container">
    <div id="logo-succesvol" title="Super Internet Shop">
    </div>
	
<?php

$token = $_GET['token'] ;
$db = connect_to_db();
$sql = $db->prepare("UPDATE Gebruikers SET status = 2 WHERE activatie_token = ? LIMIT 1");
$sql->bind_param("s", $token) ;
$sql->execute();

$sql2 = $db->prepare("UPDATE Gebruikers SET activatie_token = NULL WHERE activatie_token = ? LIMIT 1");
$sql2->bind_param("s", $token) ;
$sql2->execute();

?>

    
    <div class="bedankje">
        <p class="bedankje"> Bedankt, uw registratie is geverifieerd.</p>
        <a href="frontpage.php">
        <p class="bedankje">Klik hier om terug te keren naar het hoofdmenu</p>
        </a>
    </div>
    
</div>

