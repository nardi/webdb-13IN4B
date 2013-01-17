<?php
    require 'main.php';

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
        
        $db = connect_to_db();
        $sql = $db->prepare("SELECT prijs, hoeveelheid FROM Bestelling_Product JOIN Bestellingen ON Bestellingen.id = bestelling_id WHERE Bestellingen.id = ?");
        $sql->bind_param('i', $bestelling);
        if (!$sql->execute())
            die("wrong query");
        $sql->bind_result($prijs, $hoeveelheid);
        $totaalprijs = 0;
        while ($sql->fetch())
            $totaalprijs += $prijs * $hoeveelheid;
        $sql->free_result();
        
        $total_price = $_POST['mc_gross']; //moet gelijk zijn aan prijs bestelling
        $business = $_POST['business']; // moet gelijk zijn aan "paypal@superinternetshop.nl"
        $status = $_POST['payment_status']; // Pending of Completed
        
        error_log("totaalprijs: $totaalprijs/$total_price, business: $business, status: $status");
        
        if ($total_price == $totaalprijs && $business == 'paypal_1358181822_biz@nardilam.nl')
        {
            if ($status == 'Pending')
                $status = 'Betaling wordt verwerkt';
            else if ($status == 'Completed')
                $status = 'Betaald';
            else
                exit();
            
            $sql = $db->prepare("UPDATE Bestellingen SET betaalstatus = ? WHERE id = ?");
            $sql->bind_param('si', $status, $bestelling);
            if (!$sql->execute())
                die("wrong query 2");
        }
        
        $db->close();
    }
    else
        error_log("Unverified ipn request");
?>