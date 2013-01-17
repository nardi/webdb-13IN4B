<?php
    require 'ww-definitie.php';

    if (!isset($_SESSION['winkelwagen']))
        $_SESSION['winkelwagen'] = new Winkelwagen();

    foreach ($_SESSION['winkelwagen']->get_all() as $id)
    {
        if (isset($_POST["amount-$id"]))
            $_SESSION['winkelwagen']->change_amount($id, $_POST["amount-$id"]);
    }
    
    if (isset($_GET['add']))
        $_SESSION['winkelwagen']->add($_GET['add']);
    
    $ww = $_SESSION['winkelwagen'];
?>

<div id="cart">

<h1>Winkelwagen</h1>

<?php
    if ($ww->is_empty()) { 
?>
<h2>Er bevinden zich geen producten in je winkelwagen.</h2>
<?php
    }
    else
    {
        echo $ww->display(TRUE);
?>
<p>Voer uw wachtwoord opnieuw in ter controle:</p>
<form action="bestelling.php" method="post">
    <input type="password" name="wachtwoord">
    <input type="submit" value="Plaats bestelling"><br/>
</form>
<?php
    }
?>
</div>