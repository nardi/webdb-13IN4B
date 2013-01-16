<?php
    function get_address($postcode, $nummer, $toevoeging = '')
    {
        $ch = curl_init("https://api.postcode.nl/rest/addresses/$postcode/$nummer/$toevoeging");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "d9liJoGnbWooCGhi1K5xqiqgq6tX6A65Iv3gXMAWtxh:ovoNbJYrM4aPZetTdvdkzj9RVTovfqaFtZhkjCIBxJE");
        
        return curl_exec($ch);
    }
    
    echo get_address($_GET['postcode'], $_GET['nummer'], isset($_GET['toevoeging']) ? $_GET['toevoeging'] : '');
?>