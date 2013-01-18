
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
    <?php
        if(isset($_SESSION['logged-in']))
            echo " "
        else
            echo '<a href="registratie.html">Registreren</a><br />'
    ?>    
    
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
    $ww = Winkelwagen::try_load_from_session();
    $aantal = '';
    if (!$ww->is_empty())
        $aantal = ' (' . count($ww->get_all()) . ')';
?>
<div id="acc-mand">
    <a href="account-overzicht.php">Mijn account</a><br />
    <a href="winkelwagen.php">Winkelwagen<?php echo $aantal; ?></a>
</div>


    
    
    


