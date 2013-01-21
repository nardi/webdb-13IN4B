<?php
class Winkelwagen
{
    private $producten;
    
    private function __construct()
    {
        $this->producten = array();
    }
    
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
        if (array_key_exists($id, $this->producten))
        {
            $this->producten[$id]++;
        }
        else
        {    
            $db = connect_to_db();
            
            $sql = $db->prepare("SELECT * FROM Producten WHERE id = ? LIMIT 1");
            $sql->bind_param('i', $id);
            $sql->execute();
            
            if ($sql->fetch())
                $this->producten[$id] = 1;
                
            $sql->free_result();
            $db->close();
        }
    }
    
    function change_amount($id, $amount)
    {
        if (isset($this->producten[$id]))
        {
            if ($amount == 0)
                $this->remove($id);
            else
                $this->producten[$id] = $amount;
        }
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
    
    function get_cover($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT cover FROM Producten WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        $sql->bind_result($cover);
        $sql->fetch();
        $sql->free_result();
    
        return $cover;
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
        return count($this->producten) == 0;
    }
    
    function display($editable)
    {
?>
<script src="winkelwagen.js"></script>
<?php if ($editable) echo '<form method="post">'; ?>
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
            $cover = $this->get_cover($id);
            
            $productprijs = $hoeveelheid * $prijs;
?>
        <tr>
            <td class="product-id"><a href="item-description.php?id=<?php echo $id; ?>"><span name="product-id"><?php echo $id; ?></span></a></td>
            <td class="product-image"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($cover).'" />';?></a></td>
            <td class="product-title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></td>
            <td>&euro;<span id="price-<?php echo $id; ?>"><?php echo $prijs; ?></span></td>
            <td><input type="text" class="product-amount" id="amount-<?php echo $id; ?>" value="<?php echo $hoeveelheid; ?>" <?php if (!$editable) echo 'disabled="disabled"'; else echo 'onchange="changeAmount(' . $id . ');"'; ?> /></td>
            <td>&euro;<span id="productprice-<?php echo $id; ?>"><?php echo $productprijs; ?></span></td>
        </tr>
<?php
            $totaalprijs += $productprijs;
        }
?>
        <tr class="total-price">
            <td class="update-button" colspan="3"><?php if (false) echo '<input type="submit" value="Update hoeveelheden"/>'; ?></td>
            <th colspan="2">Totale prijs:</td>
            <td>&euro;<span id="total-price" class="price"><?php echo $totaalprijs; ?><span></td>
        </tr>
    </table>
<?php if ($editable) echo '</form>'; ?>
<?php
    }
}
?>