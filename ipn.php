<?php
    /*
     *  Dit bestand kan omgaan met de Instant Payment Notification-meldingen van PayPal.
     *  Hiermee geeft PayPal op een veilige manier de staat van de betaling door.
     */

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
    
    // Stuur de POST-data terug naar PayPal ter verificatie
    $post_data = file_get_contents('php://input');
    $verify_data = "cmd=_notify-validate&" . $post_data;
    $result = https_post("https://www.sandbox.paypal.com/nl/cgi-bin/webscr", $verify_data);
    
    if ($result === "VERIFIED" && $_POST['test_ipn'] != 1)
    {
        // De bestelling-id is opgeslagen in het custom-veld
        $bestelling = $_POST['custom'];
        
        // Totaalbedrag bestelling berekenen
        $db = connect_to_db();
        $sql = $db->prepare("SELECT prijs, hoeveelheid, verzendkosten FROM Bestelling_Product JOIN Bestellingen ON Bestellingen.id = bestelling_id WHERE Bestellingen.id = ?");
        $sql->bind_param('i', $bestelling);
        $sql->execute();
        $sql->bind_result($prijs, $hoeveelheid, $verzendkosten);
        $totaalbedrag = 0;
        while ($sql->fetch())
            $totaalbedrag += $prijs * $hoeveelheid;
        $totaalbedrag += $verzendkosten;
        $sql->free_result();
        
        $total_price = $_POST['mc_gross']; // moet gelijk zijn aan totaalbedrag bestelling
        $business = $_POST['business']; // moet gelijk zijn aan "paypal@superinternetshop.nl"
        $status = $_POST['payment_status']; // Pending of Completed
        
        if ($total_price == $totaalbedrag && $business == 'paypal@superinternetshop.nl')
        {
            //Een log voor de zekerheid (bijvoorbeeld als een onbekende status ontvangen wordt)
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
        
        require_once 'email.php';
        bestelling_mail($bestelling, 'U heeft betaald voor uw bestelling bij Super Internet Shop',
        'Uw betaling wordt zo snel mogelijk verwerkt en uw bestelling wordt daarna zo spoedig mogelijk verzonden.<br/>
        Wanneer dit gebeurt krijgt u van ons een email ter bevestiging.<br/>
        U kunt ook altijd zelf de situatie in de gaten houden via uw accountoverzicht, of contact met ons opnemen als u vragen heeft.<br/>
        Bedankt voor uw bestelling bij SuperInternetShop.nl!');
        
        $db->close();
    }
    else
        error_log("Unverified IPN request: " . $post_data);
?>