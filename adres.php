<?php
    $postcode = $_GET['postcode'];
    $nr = $_GET['nr'];
    
    echo file_get_contents('https://d9liJoGnbWooCGhi1K5xqiqgq6tX6A65Iv3gXMAWtxh:ovoNbJYrM4aPZetTdvdkzj9RVTovfqaFtZhkjCIBxJE@api.postcode.nl/rest/addresses/' . postcode + '/' . nr);
?>