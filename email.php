<?php
    function leuke_mail($email, $subject, $html, $css = '')
    {
        require_once 'CssToInlineStyles.php';
        $converter = new TijsVerkoyen\CssToInlineStyles\CssToInlineStyles($html, $css);
        mail($email,
             $subject,
             $converter->convert(),
             "From: \"Super Internet Shop\" <contact@superinternetshop.nl>\r\nContent-type: text/html");
    }
    
    function bestelling_mail($bestelling_id, $subject, $message)
    {
        $email_sql = $db->prepare("SELECT email FROM Gebruikers JOIN Bestellingen ON Gebriukers.id = gebruiker_id WHERE Bestellingen.id = ?");
        $email_sql->bind_param('i', $bestelling_id);
        $email_sql->bind_result($email);
        $email_sql->execute();
        if ($email_sql->fetch())
        {
            $html = "<html>
                     <body>
                        $message<br/>Hier is nogmaals te zien wat u precies besteld heeft:<br/>" . bestelling_weergeven($bestelling_id, TRUE) .
                    "</body>
                     </html>";
            $css = file_get_contents('main.css') . "\n\n" .
                   file_get_contents('productlijst.css') . "\n\n" .
                   file_get_contents('adresweergave.css');
            leuke_mail($email, $subject, $html, $css);
        }
        $email_sql->free_result();
    }
?>