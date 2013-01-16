<?php
    session_start();
    $pag = (isset($_GET['pag'])) ? ($_GET['pag']) : ('frontpage.html'); //read URL-pag parameter in
    if (strpos($pag, '.'))
    {
        $pagename = implode('.', explode('.', $pag, -1));
    }
    else
    {
        $pagename = $pag;
    }
?>
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="Content of Site" content="Super Internet Shop, a webshop made by UvA" />
        <link rel="shortcut icon" href="favicon.ico" />
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
        <?php if (file_exists($pagename . ".css"))
                echo '<link rel="stylesheet" type="text/css" href="' . $pagename . '.css" />';
        ?>
</head>

<body>

<div id="mainWindow">

    <div id="banner" class="vcenter-container">

        <div id="logo" onClick="window.open('/', '_self');">
            <img src="images/logo/logo-sis.png" alt="Link to homepage" />
        </div>

        <div id="dashboard" class="vcenter">
            <?php
            include("dashboard.php");
			?>
        </div>
    </div>

    <div id="contentWindow">
        <div id="sidebar">
            <div class="clickable-item" onClick="window.open('/', '_self');">
                Beginpagina
            </div>
            <div class="clickable-item" onClick="window.open('overons.html', '_self');">
                Over ons
            </div>
            <div class="clickable-item" onClick="window.open('overons.html#contact', '_self');">
                contact
            </div>
            <div class="clickable-item" onClick="window.open('wachtwoordvergeten.html', '_self');">
                Wachtwoord vergeten
            </div>
            <div class="clickable-item" onClick="window.open('item-description.html', '_self');">
                Productbeschrijving
            </div>
            <div class="clickable-item" onClick="window.open('category.php', '_self');">
                Categorie
            </div>
            <div class="clickable-item" onClick="window.open('indexbeta.php', '_self');">
                Beta-layout
            </div>
			
			<?php
				//session_start();
				
				if (isset($_SESSION['logged-in'])) {
					if ($_SESSION['gebruiker-status'] == 3) {
						?>
						<hr>
						<div class="clickable-item" onClick="window.open('product-toevoegen.php', '_self');">
							Product Toevoegen
						</div>
						<?php
					}
				}
			?>
        </div>
        
        <div id="content">
            <?php
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