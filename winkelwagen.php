<?php
    require 'ww-definitie.php';

    $ww = Winkelwagen::try_load_from_session();
    
    foreach ($ww->get_all() as $id)
    {
        if (isset($_POST["amount-$id"]))
            $ww->change_amount($id, $_POST["amount-$id"]);
    }
    
    if (isset($_GET['add']))
        $ww->add($_GET['add']);
    
    $ww->save_to_session();
?>

<div id="cart">

<h1>Winkelwagen</h1>

<?php
    if ($ww->is_empty())
    { 
?>
<p>Er bevinden zich geen producten in je winkelwagen.</p>
<?php
    }
    else
    {
        echo $ww->display(TRUE, $_GET['pag']);
?>
<br/>
<p>Voer uw wachtwoord opnieuw in ter controle voor u een bestelling plaatst:</p><br/>
<form action="bestelling.php" method="post">
    <input type="password" name="wachtwoord">
    <input type="submit" value="Plaats bestelling"><br/>
</form>
<?php
    }
?>
</div>