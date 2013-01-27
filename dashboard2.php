<?php
if(!isset($_SESSION['logged-in'])) {
    ?>
    <script>
        function emptyOrDefault(elem,dv) { elem.value = elem.value == '' ? dv : elem.value; }
    </script>
    
    <form action="gebruikers-login.php" method="post">
        <input type="text" name="e-mailadres" value="E-mailadres" onfocus="value=''" onblur="emptyOrDefault(this, 'E-mailadres')">
        <div id="ww-dash" class="clickable-item" onclick="window.location = 'winkelwagen.php'">
            <?php    
            $ww = Winkelwagen::try_load_from_session();
            $aantal = '';
            if (!$ww->is_empty())
                $aantal = ' (' . count($ww->get_all()) . ')';
            ?>
            <div id="ww-content">
                <?php echo $aantal; ?>
            </div>
        </div>
        <br />
        <input type="password" name="wachtwoord" value="wachtwoord" onfocus="value='';" onblur="emptyOrDefault(this, 'wachtwoord')">
        <br />
        <input type="submit" value="Log in"> 
        <a href='wachtwoordvergeten.php' style='float: right;'><SMALL> Wachtwoord vergeten </SMALL></a>
        <br />
        <a href="registratie.html" style='float: right; margin-top: -4px; margin-bottom: 4px;'><SMALL>Registreren</SMALL></a>
    </form>
    <?php
} else {
    echo $_SESSION['gebruiker-naam'];
    ?>
    <div id="ww-dash" class="clickable-item" onclick="window.location = 'winkelwagen.php'">
        <?php    
        $ww = Winkelwagen::try_load_from_session();
        $aantal = '';
        if (!$ww->is_empty())
            $aantal = ' (' . count($ww->get_all()) . ')';
        ?>
        <div id="ww-content">
            <?php echo $aantal; ?>
        </div>
    </div>
    <br />
    <a href="account-overzicht.php">Mijn account</a><br />
    <a href='inloggen.php'>Uitloggen</a>
    <?php
}
?>