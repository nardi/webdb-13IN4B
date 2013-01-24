<link rel="stylesheet" type="text/css" href="registratie-succesvol.css" />
<link rel="stylesheet" type="text/css" href="registratie-succesvol-classic-theme.css" />

<div class="registratie-succesvol-container">
    <div id="logo-registratie-succesvol" title="Super Internet Shop">
    </div>
	
<?php

$token = $_GET['token'] ;
$db = connect_to_db();
$sql = $db->prepare("UPDATE Gebruikers SET status = 2 WHERE activatie_token = ? LIMIT 1");
$sql->bind_param("s", $token) ;
$sql->execute();

$sql2 = $db->prepare("UPDATE Gebruikers SET activatie_token = '0' WHERE activatie_token = ? LIMIT 1");
$sql2->bind_param("s", $token) ;
$sql2->execute();

?>

    
    <div class="bedankje">
        <p class="bedankje"> Bedankt, uw registratie is geverifieerd.</p>
        <a href="frontpage.html">
        <p class="bedankje">Klik hier om terug te keren naar het hoofdmenu</p>
        </a>
    </div>
    
</div>

