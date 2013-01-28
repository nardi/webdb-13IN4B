<div class="centered-container">
<?php
    $db = connect_to_db();
	
	$emailadres = $_POST['e-mailadres'];
    $wachtwoord = $_POST['wachtwoord'];
	
	$sql = $db->prepare("SELECT id, wachtwoord, naam, status FROM Gebruikers WHERE email = ? LIMIT 1");
	$sql->bind_param("s", $emailadres);
	$sql->execute();
	$sql->bind_result($id, $wwdb, $naam, $status);
	if (!$sql->fetch())
    {
        sleep(2);
        echo "Er is geen account gevonden met dit e-mailadres.";
    }
    else
    {        
        if (check_wachtwoord($wachtwoord, $wwdb))
        {
            $_SESSION['logged-in'] = 1;
            $_SESSION['gebruiker-id'] = $id;
            $_SESSION['gebruiker-naam'] = $naam;
            $_SESSION['gebruiker-status'] = $status;
            echo "Welkom terug, ".$_SESSION['gebruiker-naam'].'!';
            ?>
            
            <script type="text/JavaScript">
                setTimeout("location.href = '/';",1500);
            </script>
            
            <?php
        }
        else {
            sleep(2);
            echo "Fout wachtwoord ingevuld. Probeer het opnieuw.";
            ?>
            <script type="text/JavaScript">
                setTimeout("location.href = '/inloggen.php';",1500);
            </script>
            <?php
        }
    }
    $sql->free_result();
    $db->close();
?>	
</div>
