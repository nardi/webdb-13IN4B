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
        
        $db = connect_to_db();
        $sql = $db->prepare("SELECT prijs, hoeveelheid, verzendkosten FROM Bestelling_Product JOIN Bestellingen ON Bestellingen.id = bestelling_id WHERE Bestellingen.id = ?");
        $sql->bind_param('i', $bestelling);
        $sql->execute();
        $sql->bind_result($prijs, $hoeveelheid, $verzendkosten);
        $totaalprijs = 0;
        while ($sql->fetch())
            $totaalprijs += $prijs * $hoeveelheid;
        $totaalprijs += $verzendkosten;
        $sql->free_result();
        
        $total_price = $_POST['mc_gross']; // moet gelijk zijn aan prijs bestelling
        $business = $_POST['business']; // moet gelijk zijn aan "paypal@superinternetshop.nl"
        $status = $_POST['payment_status']; // Pending of Completed
        
        //error_log("totaalprijs: $totaalprijs/$total_price, business: $business, status: $status");
        
        if ($total_price == $totaalprijs && $business == 'paypal_1358181822_biz@nardilam.nl')
        {
            error_log("IPN request: bestelling " . $bestelling . " is nu " . "'$status'");
        
            if ($status == 'Pending')
                $status = 'Betaling wordt verwerkt';
            else if ($status == 'Completed')
                $status = 'Betaald';
            else
                exit();
            
            $sql = $db->prepare("UPDATE Bestellingen SET betaalstatus = ? WHERE id = ?");
            $sql->bind_param('si', $status, $bestelling);
            $sql->execute();
        }
        
        $email_sql = $db->prepare("SELECT email FROM Bestellingen JOIN Gebruikers ON Gebruikers.id = gebruiker_id WHERE Bestellingen.id = ?");
        $email_sql->bind_param('i', $bestelling);
        $email_sql->bind_result($email);
        $email_sql->execute();
        if ($email_sql->fetch())
        {
            mail($email,
                 'U heeft betaald voor uw bestelling bij Super Internet Shop',
                 '<html>
                  <head>
                    <style type="text/css">' . "\n" .
                       file_get_contents('productlijst.css') . "\n" .
                       file_get_contents('centering.css') . "\n" .
                   '</style>
                  </head>
                  <body>
                    Uw betaling wordt zo snel mogelijk verwerkt.<br/>Hier is nogmaals te zien wat u precies besteld heeft:<br/>' . bestelling_weergeven($bestelling, TRUE) .
                 '</body>
                  </html>',
                 "From: \"Super Internet Shop\" <contact@superinternetshop.nl>\r\nContent-type: text/html");
        }
        $email_sql->free_result();
        
        $db->close();
    }
    else
        error_log("Unverified IPN request: " . $post_data);
?>