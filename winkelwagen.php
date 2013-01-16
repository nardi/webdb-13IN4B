<?php
    require 'main.php';
    require 'ww-definitie.php';

    if (!isset($_SESSION['winkelwagen']))
        $_SESSION['winkelwagen'] = new Winkelwagen();
    
    foreach ($_SESSION['winkelwagen']->get_all() as $id)
    {
        if (isset($_POST["amount-$id"]))
            $_SESSION['winkelwagen']->change_amount($id, $_POST["amount-$id"]);
    }
    
    $ww = $_SESSION['winkelwagen'];
?>

<div id="cart">

<h1>Winkelwagen</h1>

<?php
   if ($ww->is_empty()) { 
?>
<h2>Er bevinden zich geen producten in je winkelwagen.</h2>
<?php
   } else { 
?>
<form>
    <table class="product-list">
        <tr>
            <th>#</th>
            <th colspan="2">Product</th>
            <th>Prijs</th>
            <th>Hoeveelheid</th>
            <th>Totaal</th>
        </tr>
<?php
        $db = connect_to_db();
        $totaalprijs = 0;
        foreach ($ww->get_all() as $id)
        {
            $hoeveelheid = $ww->get_amount($id);
        
            $sql = $db->prepare("SELECT titel, prijs FROM Producten WHERE id = ? LIMIT 1");
            $sql->bind_param('i', $id);
            $sql->execute();
            $sql->bind_result($titel, $prijs);
            $sql->fetch();
            
            $productprijs = $hoeveelheid * $prijs;
?>
        <tr>
            <td class="product-id"><a href="product.php?id=<?php echo $id; ?>"><?php echo $id; ?></a></td>
            <td class="product-image"><a href="product.php?id=<?php echo $id; ?>"><img src="images/products/<?php echo $id; ?>.jpg" /></a></td>
            <td class="product-title"><a href="product.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></td>
            <td>&euro;<?php echo $prijs; ?></td>
            <td><input type="text" name="amount-<?php echo $id; ?>" value="<?php echo $hoeveelheid; ?>" /></td>
            <td>&euro;<?php echo $productprijs; ?></td>
        </tr>
<?php
            $sql->free_result();
            $totaalprijs += $productprijs;
        }
?>
        <tr class="total-price">
            <td class="update-button" colspan="3"><input type="submit" value="Update hoeveelheden" action="post" /></td>
            <th colspan="2">Totale prijs:</td>
            <td><span class="price">&euro;<?php echo $totaalprijs; ?><span></td>
        </tr>
    </table>
</form>
<?php
    }
?>
</div>