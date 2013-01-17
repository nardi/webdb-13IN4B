
<div id="inlog-status">
    <?php 
    if (isset($_SESSION['logged-in'])) {
        echo $_SESSION['gebruiker-naam'];
    }
    else {
        echo "Niet ingelogd";
    }
    ?>
</div>

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
<?php
    require 'ww-definitie.php';
    
    $ww = Winkelwagen::try_load_from_session();
    $aantal = '';
    if (!$ww-is_empty())
        $aantal = ' (' . count($ww->getAll) . ')';
?>
<div id="acc-mand">
    <a href="account-overzicht.php">Mijn account</a><br />
    <a href="winkelwagen.php">Winkelwagen<?php echo $aantal; ?></a>
</div>
    
    
    


