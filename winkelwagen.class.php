<?php require_once 'voorraad.php';

class Winkelwagen
{
    /*
     * Intern wordt een winkelwagen gerepresenteerd als
     * een array van product-id's naar hoeveelheden
     */
    private $producten;
    
    private function __construct()
    {
        $this->producten = array();
    }
    
    /*
     * Deze functie probeert een Winkelwagen uit de standaard sessie-variabele te laden,
     * of maakt een lege aan als dit niet lukt
     */
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
    
    /*
     * Deze functie slaat de huidige winkelwagen op op de standaardlocatie
     */
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
    
    /*
     * Deze functie voegt een product toe als deze op voorraad is (en bestaat),
     * of voegt een extra exemplaar toe als deze al in de winkelwagen zit
     */
    function add($id)
    {
        if (is_op_voorraad($id))
        {
            if (array_key_exists($id, $this->producten))
            {
                $this->change_amount($id, $this->producten[$id] + 1);
            }
            else
            {    
                $this->producten[$id] = 1;
            }
        }
    }
    
    /*
     * Deze functie verandert de hoeveelheid van een product, mits deze in de
     * winkelwagen zit en $amount een integer is
     */
    function change_amount($id, $amount)
    {
        $intamount = intval($amount);
        $voorraad = voorraad($id);
        if (isset($this->producten[$id]) && ($intamount > 0 || $amount === '0'))
        {
            if ($intamount == 0)
                $this->remove($id);
            else if ($voorraad < $intamount)
            {
                $this->producten[$id] = $voorraad;
            }
            else
                $this->producten[$id] = $intamount;
        }
    }
    
    /*
     * Deze functie controleert of deze winkelwagen nog besteld kan worden
     * (i.e. alle producten zijn op voorraad) en past deze zodanig aan.
     * Als er veranderingen hierdoor zijn plaatsgevonden, returnt deze true
     * zodat dat aangegeven kan worden aan de gebruiker
     */
    function check_amounts()
    {
        $verandering = false;
        foreach ($this->get_all() as $id)
        {
            $voorraad = voorraad($id);
            if ($voorraad < $this->producten[$id])
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
    
    /*
     * Verzendkosten worden op dit moment aangegeven via een globale variabele.
     * Als dit anders moet gebeuren (bijvoorbeeld afhankelijk van soort of aantal
     * producten) kan deze functie vervangen worden en wordt dit overal overgenomen.
     */
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
    
    /*
     * Deze functie geeft de winkelwagen weer. $editable geeft aan of de hoeveelheden
     * kunnen worden aangepast en of producten kunnen worden verwijderd
     */
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
            <td class="product-image"><a href="item-description.php?id=<?php echo $id; ?>"><img src="<?php echo is_valid_cover($cover); ?>" alt="Cover" /></a></td>
            <td class="product-title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></td>
            <td>&euro;<span id="price-<?php echo $id; ?>"><?php echo prijs_opmaak($prijs); ?></span></td>
            <td><input type="text" class="product-amount" id="amount-<?php echo $id; ?>" value="<?php echo $hoeveelheid; ?>" <?php if (!$editable) echo 'disabled="disabled"'; else echo 'onchange="changeAmount(' . $id . ');"'; ?> /></td>
            <td>&euro;<span id="productprice-<?php echo $id; ?>"><?php echo prijs_opmaak($productprijs); ?></span></td>
        </tr>
<?php
            $totaalbedrag += $productprijs;
        }
        $totaalbedrag += $verzendkosten;
?>
        <tr class="bottom-row">
            <td colspan="<?php if ($editable) echo '6'; else echo '5'; ?>" class="right">Verzendkosten:</th>
            <td>&euro;<span id="shipping"><?php echo prijs_opmaak($verzendkosten); ?></span></td>
        </tr>
        <tr class="bottom-row">
            <th colspan="<?php if ($editable) echo '6'; else echo '5'; ?>" class="right">Totaalbedrag:</th>
            <td>&euro;<span id="total-price"><?php echo prijs_opmaak($totaalbedrag); ?></span></td>
        </tr>
    </table>
<?php
    }
}
?>