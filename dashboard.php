<?php 
	if (isset($_SESSION['logged-in'])) {
        echo $_SESSION['gebruiker-naam'];
	}
	else {
		echo "Niet ingelogd";
	}
       
    ?>
    <div id="reg-log">
        <a href="registratie.html">Registreren</a><br />
        
        <?php
            if (!isset($_SESSION['logged-in'])) {
                echo "<a href='inloggen.php'>Inloggen</a>";
            }
            else {
                echo "<a href='inloggen.php'>Uitloggen</a>";
            }
         ?>
         
    </div>
    <div id="acc-mand">
        <a href="account-overzicht.html">Mijn account</a><br />
        <!-- Link naar nieuwe winkelwagen hier -->
        <a href="cart.html">Winkelwagen (3)</a>
    </div>
    
    
    
?>

<div id="reg-log">
	<a href="registratie.html">Registreren</a><br />
    <a href="inloggen.php">Inloggen</a>
</div>
<div id="acc-mand">
    <a href="account-overzicht.html">Mijn account</a><br />
    <!-- Link naar nieuwe winkelwagen hier -->
    <a href="cart.html">Winkelwagen (3)</a>
</div>

