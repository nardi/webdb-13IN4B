<?php
require 'main.php';

class Winkelwagen
{
    private $producten = array();
    
    public static function try_load_from_session()
    {
        $ww = new Winkelwagen();
        if (isset($_SESSION['winkelwagen']))
        {
            $ww->producten = $_SESSION['winkelwagen'];
        }
        return $ww;
    }
    
    function save_to_session()
    {
        $_SESSION['winkelwagen'] = $this->producten;
    }
    
    function add($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT * FROM Producten WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        
        if ($sql->fetch())
            $this->producten[$id] = 1;
            
        $sql->free_result();
    }
    
    function change_amount($id, $amount)
    {
        if (isset($this->producten[$id]))
            $this->producten[$id] = $amount;
    }
    
    function get_amount($id)
    {
        return $this->producten[$id];
    }
    
    function get_title($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT titel FROM Producten WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        $sql->bind_result($titel);
        $sql->fetch();
        $sql->free_result();
    
        return $titel;
    }
    
    function get_price($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT prijs FROM Producten WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        $sql->bind_result($prijs);
        $sql->fetch();
        $sql->free_result();
    
        return $prijs;
    }
    
    function get_all()
    {
        return array_keys($this->producten);
    }
    
    function remove($id)
    {
        unset($this->producten[$id]);
    }
    
    function is_empty()
    {
        return count($this->producten) === 0;
    }
    
    function display($editable)
    {
?>
<?php if ($editable) echo '<form>'; ?>
    <table class="product-list">
        <tr>
            <th>#</th>
            <th colspan="2">Product</th>
            <th>Prijs</th>
            <th>Hoeveelheid</th>
            <th>Totaal</th>
        </tr>
<?php
        $totaalprijs = 0;
        foreach ($this->get_all() as $id)
        {
            $hoeveelheid = $this->get_amount($id);
            $titel = $this->get_title($id);
            $prijs = $this->get_price($id);
            
            $productprijs = $hoeveelheid * $prijs;
?>
        <tr>
            <td class="product-id"><a href="product.php?id=<?php echo $id; ?>"><?php echo $id; ?></a></td>
            <td class="product-image"><a href="product.php?id=<?php echo $id; ?>"><img src="images/products/<?php echo $id; ?>.jpg" /></a></td>
            <td class="product-title"><a href="product.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></td>
            <td>&euro;<?php echo $prijs; ?></td>
            <td><input type="text" name="amount-<?php echo $id; ?>" value="<?php echo $hoeveelheid; ?>" <?php if (!$editable) echo 'disabled="disabled"'; ?>/></td>
            <td>&euro;<?php echo $productprijs; ?></td>
        </tr>
<?php
            $totaalprijs += $productprijs;
        }
?>
        <tr class="total-price">
            <td class="update-button" colspan="3"><?php if ($editable) echo '<input type="submit" value="Update hoeveelheden" action="post" />'; ?></td>
            <th colspan="2">Totale prijs:</td>
            <td><span class="price">&euro;<?php echo $totaalprijs; ?><span></td>
        </tr>
    </table>
<?php if ($editable) echo '</form>'; ?>
<?php
    }
}
?>