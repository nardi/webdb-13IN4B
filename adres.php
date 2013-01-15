<?php
    $postcode = $_GET['postcode'];
    $nummer = $_GET['nummer'];
    $toevoeging = isset($_GET['toevoeging']) ? '/' . $_GET['toevoeging'] : '';
    
    $ch = curl_init("https://api.postcode.nl/rest/addresses/$postcode/$nummer" . $toevoeging);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "d9liJoGnbWooCGhi1K5xqiqgq6tX6A65Iv3gXMAWtxh:ovoNbJYrM4aPZetTdvdkzj9RVTovfqaFtZhkjCIBxJE");
    
    echo curl_exec($ch);
?>