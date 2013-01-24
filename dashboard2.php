<div id="account-opties">

    <?php
    if(!isset($_SESSION['logged-in'])) {
        ?>
        
        <form action="gebruikers-login.php" method="post">
            <input type="text" name="e-mailadres" value="E-mail adres"><br />
            <input type="password" name="wachtwoord" value="wachtwoord"><br />
            <input type="submit" value="Log in"> 
        
            <a href='wachtwoordvergeten.html'><SMALL> Wachtwoord vergeten </SMALL></a>
             - 
            <a href="registratie.html"><SMALL>Registreren</SMALL></a>
        </form>
        <?php
    }
    else {
        echo $_SESSION['gebruiker-naam']."<br />";
        ?>
        
        <a href="account-overzicht.php">Mijn account</a><br />
        <?php
        
    }
    ?>
</div>
<div id="ww-dash" onclick="window.location = 'winkelwagen.php'";>
    <?php    
    $ww = Winkelwagen::try_load_from_session();
    $aantal = '';
    if (!$ww->is_empty())
        $aantal = ' (' . count($ww->get_all()) . ')';
    ?>
    
    <?php echo $aantal; ?>
</div>