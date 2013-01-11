<<<<<<< HEAD
<?php print '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="Content of Site" content="Super Internet Shop, a webshop made by UvA" />
        <link rel="shortcut icon" href="favicon.ico" />
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<body>

<div id="mainWindow">

    <div id="banner" class="vcenter-container">

        <div id="logo" onClick="window.open('index.php?pag=frontpage.html', '_self');">
            <img src="images/logo/logo-sis.png" alt="Link to homepage" />
        </div>

        <div id="dashboard" class="vcenter">
            <div id="reg-log">
            <a href="http://sisv2.tk/index.php?pag=Registratieformulier.html">Registreren</a><br />
            <a href="http://sisv2.tk/index.php?pag=Inloggen.html">Inloggen</a>
            </div>
            <div id="acc-mand">
            <a href="http://sisv2.tk/index.php?pag=account-overzicht.html">Mijn account</a><br />
            <a href="http://sisv2.tk/index.php?pag=cart.html">Winkelwagen (3)</a>
            </div>
        </div>
    </div>

    <div id="contentWindow">
        <div id="sidebar">
            <div class="clickable-item" onClick="window.open('index.php?pag=frontpage.html', '_self');">
                frontpage
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=overons.html', '_self');">
                overons
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=Registratieformulier.html', '_self');">
                Registratieformulier
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=Wachtwoordvergeten.html', '_self');">
                Wachtwoordvergeten
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=item-description.html', '_self');">
               item-description
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=category.html', '_self');">
                category
            </div>
            <div class="clickable-item" onClick="window.open('indexbeta.php', '_self');">
                Beta-layout
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
=======
<?php print '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="Author" content="Wolter Kaper" wie="dat" />
        <link rel="shortcut icon" type="image/ico" href="Super S Icon.ico" />
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<body>

<div id="mainWindow">

    <div id="banner" class="vcenter-container">

        <div id="logo">
            <img src="images/logo/logo-sis.png" alt="Link to homepage" />
        </div>

        <div id="dashboard" class="vcenter">
            <div id="reg-log">
            <a href="http://sisv2.tk/index.php?pag=Registratieformulier.html"> Registreren </a><br />
            <a href="http://sisv2.tk/index.php?pag=Inloggen.html"> Inloggen </a>
            </div>
            <div id="acc-mand">
            <a href="http://sisv2.tk/index.php?pag=MijnAccount.html"> Mijn account </a><br />
            <a href="http://sisv2.tk/index.php?pag=cart.html"> Winkelwagen (3) </a>
            </div>
        </div>

    </div>

    <div id="contentWindow">

        <div id="sidebar">
            <div class="clickable-item" onClick="window.open('index.php?pag=frontpage.html', '_self');">
                frontpage
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=overons.html', '_self');">
                overons
            </div>
	<div class="clickable-item" onClick="window.open('index.php?pag=overons.html#contact', '_self');">
                contact
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=Registratieformulier.html', '_self');">
                Registratieformulier
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=Wachtwoordvergeten.html', '_self');">
                Wachtwoordvergeten
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=item-description.html', '_self');">
               item-description
            </div>
            <div class="clickable-item" onClick="window.open('index.php?pag=category.html', '_self');">
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
>>>>>>> contact link toegevoegd (anchor)
