<?php
    /*
     * Gebruik met: 
     */
    require 'ww-definitie.php';

    /*function show_error_page($exception)
    {
        echo "Er ging iets mis bij het laden van deze pagina:</br></br>" . $exception->getMessage();
    }*/
    
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
?>