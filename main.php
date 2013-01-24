<?php
    $imagedir = "uploads/";
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
    <?=$exception->getMessage() ?>
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
    
    function upload_image() {
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $extension = end(explode(".", $_FILES["image"]["name"]));
        if ((($_FILES["image"]["type"] == "image/gif")
        || ($_FILES["image"]["type"] == "image/jpeg")
        || ($_FILES["image"]["type"] == "image/png")
        || ($_FILES["image"]["type"] == "image/pjpeg"))
        && in_array($extension, $allowedExts)) {
            if ($_FILES["image"]["error"] > 0)
            {
                echo "Return Code: " . $_FILES["image"]["error"] . "<br>";
            }
            else
            {
                if (file_exists("uploads/" . $_FILES["image"]["name"]))
                {
                    $errormsg = "Het uploaden van de afbeelding is mislukt omdat er al een afbeelding bestaat met dezelfde naam. Deze afbeelding is nu aan het product gekoppeld.";
                }
                else
                {
                    if(!move_uploaded_file($_FILES["image"]["tmp_name"],
                    "uploads/" . $_FILES["image"]["name"])) {
                        throw new Exception("Het uploaden van het bestand is mislukt");
                    }  
                            
                    
                }
            }
            
            return $_FILES["image"]["name"];
        }
        else
        {
            throw new Exception("Ongeldig bestand. Bestand moet .jpg, .jpeg, .png of .gif zijn");
        }
?>