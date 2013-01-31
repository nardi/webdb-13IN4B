<?php
    //error_reporting(0);
    
    require 'config.php';
    
    function show_error_page($exception)
    {
?>
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
<?php
    }
    
    set_exception_handler('show_error_page');
    
    function connect_to_db()
    {
        global $db_info_file;
        $db_info = json_decode(file_get_contents($db_info_file));
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
    
    function maak_wachtwoord($wachtwoord)
    {
        //Random getal voor salt genereren
		$saltbytes = openssl_random_pseudo_bytes(32);
		$salt = bin2hex($saltbytes);

		//Hashen met SHA-256
		$wwhash = hash('sha256', $wachtwoord);
		$saltedwwhash = hash('sha256', $salt . $wwhash);

		//Combinatie salt en wachtwoordhash voor database
		$saltww = $salt . $saltedwwhash;
        return $saltww;
    }
    
    function check_wachtwoord($wachtwoord, $wwdb)
    {
        $wwhash = hash('sha256', $wachtwoord);
        $salthash = str_split($wwdb, 64);
        $salt = $salthash[0];
        $saltedwwhash = hash('sha256', $salt . $wwhash);
        return $saltedwwhash === $salthash[1];
    }
    
    /* is_logged_in() kijkt of de gebruiker ingelogd is.
     */
    
    function is_logged_in()
    {
        return isset($_SESSION['logged-in']);
    }
    
    /* is_verified_in() kijkt of de gebruiker ingelogd en geverifiëerd is. (Level 2 of hoger in de database).
     */
    
    function is_verified()
    {
        //return is_logged_in() && ($_SESSION['gebruiker-status'] >= 2);
        return true;
    }
    
    /* is_admin() kijkt of de gebruiker ingelogd is als een admin/medewerker (Level 3 of hoger in de database).
     */
    
    function is_admin()
    {
        //return is_logged_in() && ($_SESSION['gebruiker-status'] >= 3);
        return true;
    }
    
    /* is_owner() kijkt of de gebruiker ingelogd is als een owner/beheerder (Level 4 of hoger in de database).
     */
    
    function is_owner()
    {
        //return is_logged_in() && ($_SESSION['gebruiker-status'] == 4);
        return true;
    }
    
    /* upload_image() is een functie bedoeld voor het uploaden van afbeeldingen naar de server.
     * Als parameter wordt de naam van het veld waarin het bestand wordt gekozen meegegeven.
     * De functie handelt de rest zelf af.
     *
     * Deze code is gebasseerd op code gepubliceerd door W3Schools. Source: http://www.w3schools.com/php/php_file_upload.asp
     */    
    function upload_image($name) {
              
        /* Hier wordt de extensie van het bestand vergeleken met de door ons toegestane
         * extensies: .jpg, .jpeg, .gif en .png
         */
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $_FILES[$name]["name"]));
        if ((($_FILES[$name]["type"] == "image/gif")
        || ($_FILES[$name]["type"] == "image/jpeg")
        || ($_FILES[$name]["type"] == "image/png")
        || ($_FILES[$name]["type"] == "image/pjpeg"))
        && in_array($extension, $allowedExts)) {
        
            /* Als er iets mis is gegaan met het initiële uplaoden wordt deze error weergegeven
             */
            if ($_FILES[$name]["error"] > 0)
            {
                throw new Exception("Er is iets mis gegaan met het uploaden van de afbeelding. Ga terug, en probeer het opnieuw");
            }
            else
            {  
                /* Kijk hier nog ff naar...
                 */
                if (file_exists("uploads/" . $_FILES[$name]["name"]))
                {
                    $errormsg = "Het uploaden van de afbeelding is mislukt omdat er al een afbeelding bestaat met dezelfde naam. Deze afbeelding is nu aan het product gekoppeld.";
                }
                else
                {
                    /* Als alles goed gaat, wordt het bestand uit de tmp folder gehaald en verplaatst naar de folder uploads.
                     * Mocht dit misgaan, dan wordt er een error weergeven.
                     */
                    if(!move_uploaded_file($_FILES[$name]["tmp_name"],
                    "uploads/" . $_FILES[$name]["name"])) {
                        throw new Exception("Het uploaden van het bestand is mislukt");
                    }   
                }
            }
            
            /* De naam van het bestand wordt gereturned, zodat deze in de database kan worden gekoppeld aan het product
             */
            return $_FILES[$name]["name"];
        }
        else
        {
            throw new Exception("Ongeldig bestand. Bestand moet .jpg, .jpeg, .png of .gif zijn");
          
        }
    }
    
    /* is_valid_cover() kijkt of de naam van de cover voorkomt in de map uploads, en of er überhaubt wel een 
     * cover is gekoppeld aan het product. 
     */
    function is_valid_cover($cover) 
    {
        $imgdir = "uploads/";
        
        /* Als er geen cover is gekoppeld aan het product, of als de cover niet meer bestaat op de server
         * dan wordt nocover.png afgebeeld.
         */
        if ((!file_exists($imgdir . $cover)) || (is_null($cover))) {
            $cover = "nocover.png";
        }
        /* Aan de naam van de cover wordt het pad naar de folder geplakt. Het geheel wordt gereturned, zodat 
         * de aanroepende code makkelijk de afbeelding kan weergeven
         */
        $cover = $imgdir . $cover;
        return $cover;
    }
    
    function prijs_opmaak($num)
    {
        if (intval($num) == $num)
            return intval($num) . ',-';
        return number_format($num, 2, ',', '');
    }
    
    function aanbiedingsprijs($id)
    {
        $db = connect_to_db();
        
        $sql = $db->prepare("SELECT prijs FROM Aanbiedingen WHERE product_id = ? AND start_datum <= CURRENT_DATE AND eind_datum >= CURRENT_DATE LIMIT 1");
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
?>