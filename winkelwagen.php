<div id="winkelwagen">

<h1>Winkelwagen</h1>

<?php
    require_once 'winkelwagen.class.php';

    $ww = Winkelwagen::try_load_from_session();
    
    if (isset($_POST['add']))
    {
        require_once 'voorraad.php';
        if (is_op_voorraad($_POST['add']))
            $ww->add($_POST['add']);
        else
            echo '<p>Dit product is niet meer op voorraad.</p>';
    }
        
    if (isset($_POST['remove']))
        $ww->remove($_POST['remove']);
    
    $ww->save_to_session();
?>
<?php
    if ($ww->is_empty())
    { 
?>
<p>Er bevinden zich geen producten in uw winkelwagen.</p>
<?php
    }
    else
    {
        if ($ww->check_amounts())
            echo '<p>Sommige producten in uw winkelwagen zijn niet meer op voorraad. Uw winkelwagen is hiervoor aangepast.</p>';
        echo $ww->display(TRUE);
?>
<br/>
<?php
        if (is_logged_in())
        {
?>
<form>
    <a href="bestellen.php"><input type="button" value="Naar de kassa" /></a>
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