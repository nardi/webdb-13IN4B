<?php
    $verzendkosten = 6.75;
    
    function show_error_page($exception)
    {
?>
<center>
    <h4><strong>FAIL WHALE</strong></h4>
    <h5>Oeps, er ging iets vaudt.</h5>
    <pre style="display: inline-block">

            _.._
           (_.-.\
       .-,       `
  .--./ /     _.-""-.
   '-. (__..-"       \
      \          a    |
       ',.__.   ,__.-'/
         '--/_.'----'`
        Whale, whale, whale. What do we have here?		
	</pre>
    <br />
    <?php echo $exception->getMessage(); ?>
</center>
<?php
    }
    
    set_exception_handler('show_error_page');
    
    function connect_to_db()
    {
        $db_info = json_decode(file_get_contents("/datastore/webdb13IN4B/db-info.json"));
        $mysqli = new mysqli($db_info->host, $db_info->username, $db_info->password, $db_info->database);
        if ($mysqli->connect_errno)
            throw new Exception($mysqli->connect_error);
        return $mysqli;
    }
    
    function redirect_to($url)
    {
        header("location:$url");
    }
    
    function string_starts_with($string, $search) 
    { 
        return (strncmp($string, $search, strlen($search)) == 0); 
    } 
    
    function get_address($postcode, $nummer, $toevoeging = '')
    {
        $ch = curl_init("https://api.postcode.nl/rest/addresses/$postcode/$nummer/$toevoeging");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "d9liJoGnbWooCGhi1K5xqiqgq6tX6A65Iv3gXMAWtxh:ovoNbJYrM4aPZetTdvdkzj9RVTovfqaFtZhkjCIBxJE");
        
        return curl_exec($ch);
    }
    
    function check_wachtwoord($wachtwoord, $wwdb)
    {
        $wwhash = hash('sha256', $wachtwoord);
        $salthash = str_split($wwdb, 64);
        $salt = $salthash[0];
        $saltedwwhash = hash('sha256', $salt . $wwhash);
        return $saltedwwhash === $salthash[1];
    }
    
    function is_logged_in()
    {
        return isset($_SESSION['logged-in']);
    }
    
    function is_verified()
    {
        return is_logged_in() && ($_SESSION['gebruiker-status'] >= 2);
    }
    
    function is_admin()
    {
        return is_logged_in() && ($_SESSION['gebruiker-status'] >= 3);
    }
    
    function upload_image($name) {
        if ($_FILES[$name]["error"] > 0)
        {
            echo "Error: " . $_FILES[$name]["error"] . "<br>";
        }
    
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $_FILES[$name]["name"]));
        if ((($_FILES[$name]["type"] == "image/gif")
        || ($_FILES[$name]["type"] == "image/jpeg")
        || ($_FILES[$name]["type"] == "image/png")
        || ($_FILES[$name]["type"] == "image/pjpeg"))
        && in_array($extension, $allowedExts)) {
            if ($_FILES[$name]["error"] > 0)
            {
                echo "Return Code: " . $_FILES[$name]["error"] . "<br />";
            }
            else
            {
                if (file_exists("uploads/" . $_FILES[$name]["name"]))
                {
                    $errormsg = "Het uploaden van de afbeelding is mislukt omdat er al een afbeelding bestaat met dezelfde naam. Deze afbeelding is nu aan het product gekoppeld.";
                }
                else
                {
                    if(!move_uploaded_file($_FILES[$name]["tmp_name"],
                    "uploads/" . $_FILES[$name]["name"])) {
                        throw new Exception("Het uploaden van het bestand is mislukt");
                    }   
                }
            }
            
            return $_FILES[$name]["name"];
        }
        else
        {
            throw new Exception("Ongeldig bestand. Bestand moet .jpg, .jpeg, .png of .gif zijn");
        }
    }
    
    function is_valid_cover($cover) 
    {
        $imgdir = "uploads/";
        if ((!file_exists($imgdir . $cover)) || (is_null($cover))) {
            $cover = "nocover.png";
        }
        $cover = $imgdir . $cover;
        return $cover;
    }
    
    function prijs($num)
    {
        if (intval($num) == $num)
            return intval($num) . ',-';
        return number_format($num, 2, ',', '');
    }
    
    function aanbiedingsprijs($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT prijs FROM Aanbiedingen WHERE product_id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        $sql->bind_result($prijs);
        $sql->fetch();
        $sql->free_result();
        $db->close();
        
        return isset($prijs) ? $prijs : null;
    }
    
    function normale_prijs($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT prijs FROM Producten WHERE id = ? LIMIT 1");
        $sql->bind_param('i', $id);
        $sql->execute();
        $sql->bind_result($prijs);
        $sql->fetch();
        $sql->free_result();
        $db->close();
        
        return isset($prijs) ? $prijs : null;
    }
    
    function actuele_prijs($id)
    {
        $aanbiedingsprijs = aanbiedingsprijs($id);
        if ($aanbiedingsprijs === null)
        {
            return normale_prijs($id);
        }
        return $aanbiedingsprijs;
    }
    
    function product_thumb($id, $cover, $titel, $prijs, $aanbiedingsprijs = null, $datum = null)
    {
?>
<div class="product-thumb<?php if ($datum !== null) { ?> preorder<?php } ?>">
    <div class="image"><a href="item-description.php?id=<?php echo $id; ?>"><img src="<?php echo $cover; ?>" alt="<?php echo $titel; ?>"/></a></div>
    <p class="title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></p>
    <p><a href="item-description.php?id=<?php echo $id; ?>">
<?php if ($aanbiedingsprijs !== null) { ?>
        <span class="old-price">&euro;<?php echo prijs($prijs); ?></span><br />
        <span class="price">&euro;<?php echo prijs($aanbiedingsprijs); ?></span>
<?php } else { ?>
        <span class="price">&euro;<?php echo prijs($prijs); ?></span>
<?php } ?>
    </a></p>
    <?php if ($datum !== null) { ?><p class="date"><?php echo $datum; ?></p><?php } ?>
</div>
<?php
    }
?>