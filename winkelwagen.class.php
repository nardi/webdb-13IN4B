<?php require_once 'voorraad.php';

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
            $ww->check_amounts();
        }
        return $ww;
    }
    
    function save_to_session()
    {
        $_SESSION['winkelwagen'] = $this->producten;
    }
    
    public static function from_json($json)
    {
        $ww = new Winkelwagen();
        $ww->producten = json_decode($json);
        return $ww;
    }
    
    function to_json()
    {
        return json_encode($this->producten);
    }
    
    function add($id)
    {
        if (is_op_voorraad($id))
        {
            if (array_key_exists($id, $this->producten))
            {
                $this->change_amount($this->producten[$id] + 1);
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
    }
    
    function change_amount($id, $amount)
    {
        $voorraad = voorraad($id);
        if (isset($this->producten[$id]))
        {
            if ($amount == 0)
                $this->remove($id);
            else if ($voorraad < $amount)
            {
                $this->producten[$id] = $voorraad;
            }
            else
                $this->producten[$id] = $amount;
        }
    }
    
    function check_amounts()
    {
        $verandering = false;
        foreach ($this->get_all() as $id)
        {
            $voorraad = voorraad($id);
            if ($voorraad < $amount)
            {
                $this->change_amount($id, $voorraad);
                $verandering = true;
            }
        }
        return $verandering;
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
        return actuele_prijs($id);
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
    
    function get_shipping()
    {
        global $verzendkosten;
        return $verzendkosten;
    }
    
    function get_all()
    {
        return array_keys($this->producten);
    }
    
    function remove($id)
    {
        unset($this->producten[$id]);
    }
    
    function remove_all()
    {
        $this->producten = array();
    }
    
    function is_empty()
    {
        return count($this->producten) == 0;
    }
    
    function display($editable)
    {
        $verzendkosten = $this->get_shipping();
?>
<?php if ($editable) echo '<script src="winkelwagen.js"></script>'; ?>
    <table class="product-list">
        <tr>
            <?php if ($editable) echo '<th></th>'; ?>
            <th>#</th>
            <th colspan="2">Product</th>
            <th>Prijs</th>
            <th>Hoeveelheid</th>
            <th>Totaal</th>
        </tr>
<?php
        $totaalbedrag = 0;
        foreach ($this->get_all() as $id)
        {
            $hoeveelheid = $this->get_amount($id);
            $titel = $this->get_title($id);
            $prijs = $this->get_price($id);
            $cover = $this->get_cover($id);
            
            $productprijs = $hoeveelheid * $prijs;
?>
        <tr>
        <?php
            if ($editable)
            {
                echo '<th><form method="post">';
                echo '<input type="hidden" name="remove" value="' . $id . '" />';
                echo '<img src="images/labels/error-label.png" class="remove-button clickable-item" onclick="this.parentNode.submit();" />';
                echo '</form></th>';
            }
        ?>
            <td class="product-id"><a href="item-description.php?id=<?php echo $id; ?>"><span name="product-id"><?php echo $id; ?></span></a></td>
            <td class="product-image"><a href="item-description.php?id=<?php echo $id; ?>"><img src="<?php echo is_valid_cover($cover); ?>" alt="<?php echo $titel; ?>" /></a></td>
            <td class="product-title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></td>
            <td>&euro;<span id="price-<?php echo $id; ?>"><?php echo prijs($prijs); ?></span></td>
            <td><input type="text" class="product-amount" id="amount-<?php echo $id; ?>" value="<?php echo $hoeveelheid; ?>" <?php if (!$editable) echo 'disabled="disabled"'; else echo 'onchange="changeAmount(' . $id . ');"'; ?> /></td>
            <td>&euro;<span id="productprice-<?php echo $id; ?>"><?php echo prijs($productprijs); ?></span></td>
        </tr>
<?php
            $totaalbedrag += $productprijs;
        }
        $totaalbedrag += $verzendkosten;
?>
        <tr class="bottom-row">
            <td colspan="<?php if ($editable) echo '6'; else echo '5'; ?>" class="right">Verzendkosten:</th>
            <td>&euro;<span id="shipping"><?php echo prijs($verzendkosten); ?></span></td>
        </tr>
        <tr class="bottom-row">
            <th colspan="<?php if ($editable) echo '6'; else echo '5'; ?>" class="right">Totaalbedrag:</th>
            <td>&euro;<span id="total-price"><?php echo prijs($totaalbedrag); ?></span></td>
        </tr>
    </table>
<?php
    }
}
?>