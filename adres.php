<?php
    $postcode = $_GET['postcode'];
    $nr = $_GET['nr'];
    
    $ch = curl_init("https://api.postcode.nl/rest/addresses/$postcode/$nr");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "d9liJoGnbWooCGhi1K5xqiqgq6tX6A65Iv3gXMAWtxh:ovoNbJYrM4aPZetTdvdkzj9RVTovfqaFtZhkjCIBxJE");
    
    echo curl_exec($ch);
?>