<?php
    function post($url, $data)
    {
        $url = parse_url($url);
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
     
        return isset($result[1]) ? $result[1] : '';
    }
    
    $post_data = file_get_contents('php://input');
    $verify_data = "cmd=_notify-validate&" . $post_data;
    $result = post("https://www.sandbox.paypal.com/nl/cgi-bin/webscr", $verify_data);
    error_log($verify_data . "\n\n" . "'$result'", 1, "mij@nardilam.nl");
?>