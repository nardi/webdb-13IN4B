<?php
    $verzendkosten = 6.75;
    require 'winkelwagen.class.php';
    
    function show_error_page($exception)
    {
?>
<center>
    <h4><strong>FAIL WHALE</strong></h4>
    <h5>Oeps, er ging iets vaudt.</h5>
    <pre>

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
    <?php echo $exception->getMessage(); ?>
</center>
<?php
    }
    
    set_exception_handler('show_error_page');
    
    function connect_to_db()
    {
        $mysqli = new mysqli("localhost", "webdb13IN4B", "trestunu", "webdb13IN4B");
        if ($mysqli->connect_errno)
            throw new Exception($mysqli->connect_error);
        return $mysqli;
    }
    
    function redirect_to($url)
    {
        header("location:$url");
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
    
    function is_admin()
    {
        return is_logged_in() && ($_SESSION['gebruiker-status'] >= 3);
    }
    
    function upload_image($name) {
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $_FILES[$name]["name"]));
        if ((($_FILES[$name]["type"] == "image/gif")
        || ($_FILES[$name]["type"] == "image/jpeg")
        || ($_FILES[$name]["type"] == "image/png")
        || ($_FILES[$name]["type"] == "image/pjpeg"))
        && in_array($extension, $allowedExts)) {
            if ($_FILES[$name]["error"] > 0)
            {
                echo "Return Code: " . $_FILES[$name]["error"] . "<br>";
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
    
    function price($num)
    {
        if (intval($num) == $num)
            return intval($num) . ',-';
        return number_format($num, 2, ',', '');
    }
    
    function product_thumb($id, $cover, $titel, $prijs, $datum = null)
    {
?>
<div class="product-thumb <?php if ($datum !== null) { ?>preorder<?php } ?>">
    <div class="image"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo '<img src="' . $cover . '"/>'; ?></a></div>
    <p class="title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></p>
    <p class="price"><a href="item-description.php?id=<?php echo $id; ?>">&euro;<?php echo price($prijs); ?></a></p>
    <?php if ($datum !== null) { ?><p class="date"><?php echo $datum; ?></p><?php } ?>
</div>
<?php
    }
?>