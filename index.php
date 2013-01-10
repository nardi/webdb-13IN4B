<?php print '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="Author" content="Wolter Kaper" wie="dat" />
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<body>

<div id="mainWindow">

    <div id="banner">

        <div id="logo">
            S.I.S logo hier!
        </div>

        <div id="dashboard">
            <a href="http://sisv2.tk/index.php?pag=MijnAccount.html"> Mijn account </a><br />
            <a href="http://sisv2.tk/index.php?pag=Registratieformulier.html"> Registreren </a><br />
            <a href="http://sisv2.tk/index.php?pag=Inloggen.html"> Inloggen </a><br />
            <a href="http://sisv2.tk/index.php?pag=cart.html"> Winkelwagen (3) </a>
        </div>

    </div>

    <div id="contentWindow">

        <div id="sidebar">
            <div class="clickable-item" onClick="window.location('index.php?pag=frontpage.html');">
                frontpage
            </div>
            <div class="clickable-item" onClick="window.location('index.php?pag=overons.html');">
                overons
            </div>
            <div class="clickable-item" onClick="window.location('index.php?pag=Registratieformulier.html');">
                Registratieformulier
            </div>
            <div class="clickable-item" onClick="window.location('index.php?pag=Wachtwoordvergeten.html');">
                Wachtwoordvergeten
            </div>
            <div class="clickable-item" onClick="window.location('index.php?pag=item-description.html');">
               item-description
            </div>
            <div class="clickable-item" onClick="window.location('index.php?pag=category.html');">
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
