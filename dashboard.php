<!-- Het dashboard bevat 2 verschillende blokken:
     1 voor als de gebruiker ingelogd is, en 1 voor 
     als dit niet het geval is. -->

<?php
    require_once 'winkelwagen.class.php';

    function ww_dash()
    {
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
<?php
    }
    
    /* Als de gebruiker niet ingelogd is, dan kan die inloggen via het dashboard.
     * Het formulier hiervoor wordt hieronder gemaakt.
     */
    if(!isset($_SESSION['logged-in'])) {
    ?>
    <script type="text/javascript">
        function empty(elem,dv) { elem.value = elem.value == dv ? '' : elem.value; }
        function emptyOrDefault(elem,dv) { elem.value = elem.value == '' ? dv : elem.value; }
    </script>
    <form action="gebruikers-login.php" method="post">
        <div id="dashboard">
            <div style="overflow: auto;">
                <input type="text" name="e-mailadres" value="E-mailadres" onfocus="empty(this, 'E-mailadres')" onblur="emptyOrDefault(this, 'E-mailadres')" />
                <?php ww_dash(); ?>
                <br />
                <input type="password" name="wachtwoord" value="wachtwoord" onfocus="empty(this, 'wachtwoord')" onblur="emptyOrDefault(this, 'wachtwoord')" />
            </div>
            <input type="submit" value="Log in" /> 
            <a href='wachtwoordvergeten.php' style='float: right; font-size: small; margin-top: 4px;'>Wachtwoord vergeten</a>
            <br />
            <a href="registratie.html" style='float: right; font-size: small; margin-top: -2px; margin-bottom: 4px;'>Registreren</a>
        </div>
    </form>
<?php
    /* Als de gebruiker wel ingelogd is, dan krijgt deze een simpel dashboard
     * te zien, waarvandaan genavigeerd kan worden naar het account overzicht,
     * de winkelwagen, en de uitlog pagina.
     */
    } else {
?>
    <div id="dashboard">
        <?php ww_dash(); ?>
        <div id="account-opties">
            <?php echo $_SESSION['gebruiker-naam']; ?><br />
            <a href="account-overzicht.php">Mijn account</a><br />
            <a href='inloggen.php'>Uitloggen</a>
        </div>
    </div>
<?php
    }
?>