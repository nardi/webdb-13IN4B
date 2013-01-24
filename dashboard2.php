<?php
if(!isset($_SESSION['logged-in'])) {
    ?>
    <form action="gebruikers-login.php" method="post">
        <input type="text" name="e-mailadres" value="E-mail adres"><br />
        <input type="password" name="wachtwoord" value="wachtwoord"><br />
        <input type="submit" value="Log in"> 
	</form>
    <a href='wachtwoordvergeten.html'><SMALL> Wachtwoord vergeten </SMALL></a>
     - 
    <a href="registratie.html"><SMALL>Registreren</SMALL></a>
    <?php
}
else {
    echo $_SESSION['gebruiker-naam']."<br />";
    ?>
    
    <a href="account-overzicht.php">Mijn account</a><br />
    <?php
    
}
?>