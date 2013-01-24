<?php
if(!isset($_SESSION['logged-in'])) {
    ?>
    <input type="text" name="e-mailadres"><br />
    <input type="password" name="wachtwoord"><br />
    <a href='wachtwoordvergeten.html'><SMALL> Wachtwoord vergeten </SMALL></a>
     - 
    <a href='wachtwoordvergeten.html'><SMALL> Wachtwoord vergeten </SMALL></a>
    <a href="registratie.html">Registreren</a>
    
    <?php
}
else {
    echo $_SESSION['gebruiker-naam']."<br />";
    ?>
    
    <a href="account-overzicht.php">Mijn account</a><br />
    <?php
    
}
?>