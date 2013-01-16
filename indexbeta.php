<?php print '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="Author" content="Wolter Kaper" wie="dat" />
        <link rel="shortcut icon" type="image/ico" href="Super S Icon.ico" />
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="mainbeta.css" />
</head>

<body>

<div id="mainWindow">

    <div id="banner" class="vcenter-container">

        <div id="logo" onClick="window.open('frontpage.html', '_self');">
            <img src="images/logo/logo-sis-beta.png" alt="Link to homepage" />
        </div>

        <div id="dashboard" class="vcenter">
            <div id="reg-log">
            <a href="http://sisv2.tk/Registratieformulier.html">Registreren</a><br />
            <a href="http://sisv2.tk/Inloggen.html">Inloggen</a>
            </div>
            <div id="acc-mand">
            <a href="http://sisv2.tk/account-overzicht.html">Mijn account</a><br />
            <a href="http://sisv2.tk/cart.html">Winkelwagen (3)</a>
            </div>
        </div>
    </div>

    <div id="contentWindow">
        <div id="sidebar">
            <div class="clickable-item test" onClick="window.open('frontpage.html', '_self');">
                frontpage
            </div>
            <div class="clickable-item" onClick="window.open('overons.html', '_self');">
                overons
            </div>
            <div class="clickable-item" onClick="window.open('Registratieformulier.html', '_self');">
                Registratieformulier
            </div>
            <div class="clickable-item" onClick="window.open('Wachtwoordvergeten.html', '_self');">
                Wachtwoordvergeten
            </div>
            <div class="clickable-item" onClick="window.open('item-description.html', '_self');">
               item-description
            </div>
            <div class="clickable-item" onClick="window.open('category.html', '_self');">
                category
            </div>
        </div>
        
        <div id="content">
            <?php
                $pag = (isset($_GET['pag'])) ? ($_GET['pag']) : ('') ; //read URL-pag parameter in
                
                if (empty($pag)) {
                    include("frontpage.html");
                }
                else {
                    if (file_exists($pag)) {
                    //a legal file is requested, serve it up
                        include($pag); //fetch the file and replace '<?php ... by its contents
                    }

                    else {
                    //an illegal file is requested; serve an innocent default instead
                        echo "Allan, please add $pag";
                    }
                }
            ?>
        </div>
    </div>
</div>

</body>
</html>
