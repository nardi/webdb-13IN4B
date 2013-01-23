<?php
    $ww = Winkelwagen::try_load_from_session();
    
    if (isset($_POST['add']))
        $ww->add($_POST['add']);
        
    if (isset($_POST['remove']))
        $ww->remove($_POST['remove']);
    
    $ww->save_to_session();
?>

<div id="winkelwagen">

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
<form>
    <a href="bestellen.php"><input type="button" value="Naar de kassa"></a>
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