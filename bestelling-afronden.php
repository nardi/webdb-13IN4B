<?php
    if (!isset($_SESSION['logged-in']))
    {
        echo 'Je moet ingelogd zijn om een bestelling te plaatsen.';
    }
    else
    {
        $ww = Winkelwagen::try_load_from_session();
        
        if ($ww->is_empty())
        {
            echo 'Voeg eerst producten toe aan je winkelwagen voor je een bestelling plaatst.';
            $db->close();
        }
        else
        {
?>

<div class="centered-container">

<h1>Uw huidige bestelling</h1>

<?php
            echo $ww->display(FALSE);
?>
<br/>
<?php
            if (isset($_SESSION['logged-in']))
            {
?>
<p>Voer uw wachtwoord opnieuw in ter controle voor u een bestelling plaatst:</p>
<form action="bestelling-plaatsen.php" method="post">
    <input type="password" name="wachtwoord">
    <input type="submit" value="Plaats bestelling"><br/>
</form>
<?php
            }
            else
            {
?>
<p><a href="inloggen.php">U moet ingelogd zijn om een bestelling te kunnen plaatsen. Klik hier om in te loggen.</a></p>
<?php
            }
        }
    }
?>
</div>