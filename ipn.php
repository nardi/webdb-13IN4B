<?php
    function https_post($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        
        if(!($result = curl_exec($ch)))
        {
            error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit();
        }
        
        curl_close($ch);
        
        return $result;
    }
    
    $post_data = file_get_contents('php://input');
    $verify_data = "cmd=_notify-validate&" . $post_data;
    $result = https_post("https://www.sandbox.paypal.com/nl/cgi-bin/webscr", $verify_data);
    
    if ($result === "VERIFIED")// && $_POST['test_ipn'] != 1)
    {
        $bestelling = $_POST['custom'];
        
        //haal bestelling uit db
        
        $total_price = $_POST['mc_gross']; //moet gelijk zijn aan prijs bestelling
        $business = $_POST['business']; // moet gelijk zijn aan "paypal@superinternetshop.nl"
        $status = $_POST['payment_status']; // Pending of Completed
        
        // Set status in db afhankelijk van status
    }
    else
        error_log("Unverified ipn request");
?>