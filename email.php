<?php
    function leuke_mail($email, $subject, $html, $css = '')
    {
        require 'CssToInlineStyles.php';
        $converter = new TijsVerkoyen\CssToInlineStyles\CssToInlineStyles($html, $css);
        mail($email,
             $subject,
             $converter->convert(),
             "From: \"Super Internet Shop\" <contact@superinternetshop.nl>\r\nContent-type: text/html");
    }
?>