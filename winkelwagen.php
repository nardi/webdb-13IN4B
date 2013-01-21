<?php
    $ww = Winkelwagen::try_load_from_session();
    
    if (isset($_POST['add']))
        $ww->add($_POST['add']);
    
    $ww->save_to_session();
?>

<div id="cart">

<h1>Winkelwagen</h1>

<?php
    if ($ww->is_empty())
    { 
?>
<p>Er bevinden zich geen producten in uw winkelwagen.</p>
<?php
    }
    else
    {
        echo $ww->display(TRUE);
?>
<br/>
<?php
        if (isset($_SESSION['logged-in']))
        {
?>
<p>Voer uw wachtwoord opnieuw in ter controle voor u een bestelling plaatst:</p>
<form action="bestelling.php" method="post">
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
?>
</div>