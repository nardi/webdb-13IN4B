<?php
    function https_post($url, $data)
    {
        if (!function_exists('curl_init'))
            error_log("Geen curl :(");
    
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
        
        /* $url = parse_url($url);
        $host = $url['host'];
        $path = $url['path'];
        
        $fp = fsockopen($host, 80, $errno, $errstr, 30);
 
        if ($fp)
        {
            fputs($fp, "POST $path HTTP/1.1\r\n");
            fputs($fp, "Host: $host\r\n");     
            fputs($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-Length: " . strlen($data) . "\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $data);
     
            $result = '';
            while(!feof($fp))
                $result .= fgets($fp, 128);
        }
        else
        { 
            throw new Exception("Error opening request socket");
        }
        
        fclose($fp);
        $result = explode("\r\n\r\n", $result, 2);
     
        return isset($result[1]) ? $result[1] : ''; */
    }   
    
    $post_data = file_get_contents('php://input');
    $verify_data = "cmd=_notify-validate&" . $post_data;
    $result = https_post("https://www.sandbox.paypal.com/nl/cgi-bin/webscr", $verify_data);
    error_log($verify_data . "\n\n" . "'$result'");
?>