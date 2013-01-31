<?php
    setcookie("user", "sis_user", time()+3600 * 3600 * 3600);

    require_once 'main.php';
    
    session_start();
    
    $default_page = 'frontpage.php';
    $pag = (isset($_GET['pag'])) ? ($_GET['pag']) : $default_page; //read URL-pag parameter in
    if (string_starts_with($_SERVER['REQUEST_URI'], '/index.php'))
    {
        if (!empty($pag))
            redirect_to('/');
        else
        {
            redirect_to('/' . substr($_SERVER['REQUEST_URI'], strlen('/index.php?pag=')));
        }
    }
    
    /* Deze code komt uit de voorbeeldcode voor HTTPS, uit het bestand form.php
     */
    if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
        $uri = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        //redirect_to($uri);
    }
    
    if (strpos($pag, '.'))
    {
        $pagename = implode('.', explode('.', $pag, -1));
    }
    else if (empty($pag))
    {
        $pagename = $default_page;
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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Content of Site" content="Super Internet Shop, a webshop made by UvA students" />
        <link rel="shortcut icon" href="favicon.ico" />
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="main.css" />
        <?php if (file_exists($pagename . ".css"))
                echo '<link rel="stylesheet" type="text/css" href="' . $pagename . '.css" />';
        ?>    
        <script type="text/javascript" src="button.js"></script> 
</head>

<body onload = "setButtonColor('<?php echo $pag; ?>')">


<!-- Het hoofd-venster, waar de site in komt te staan. -->
<div id="mainWindow">
    <!-- Als de gebruiker geen javascript aan heeft staan, wordt dit hem op 
         subtiele wijze medegedeeld. -->
    <noscript>
    	<div class="red_line vcenter-container">
      	<div class="center"> <img src="/images/labels/error-label.png" alt="error-label" width="35" height="35" /> <p class="vcenter">Deze website wordt alleen juist weergegeven met Javascript.</p></div>
    	</div>
  	</noscript>
    
    <!-- De banner is de header van de site -->
    <div class="banner">
        <!-- Het logo, tevens een link naar de homepage -->
        <div id="logo" class="vcenter" onclick="onButtonclick();">
            <img src="images/logo/logo-sis-met-tekst.png" alt="Link to homepage" />
        </div>
        
        <!-- De slogan is de GIF afbeelding. -->
        <div id="slogan" class="vcenter">
            <img src="images/SIS-BANNER.gif" alt="Super Internet Shop" />
        </div>
        
        <!-- Het dashboard met daarin de accountmogelijkheden wordt geïmporteerd uit dashboard.php. -->
        <?php
            include("dashboard.php");
        ?>
    </div>
    
    <!-- Het contentWindow bevindt zich onder de banner, en bevat alle content. -->
    <div id="contentWindow">
    
        <!-- De sidebar wordt geïmporteerd uit sidebar.php, en bevat de navigatieknoppen
             voor de website. -->
        <div id="sidebar">
            <?php
                include("sidebar.php");
			?>
        </div>
        
        <!-- De code voor de content is gebasseerd op de verstrekte voorbeeldcode voor PHP frames.
             Aan de hand van de URL wordt gekeken welke pagina geïmporteerd moet worden.-->
        <div id="content">
            <?php
                /* Als er geen pagina in de url staat aangegeven, wordt automatisch
                 * de frontpage geladen
                 */
                if (empty($pag))
                {
                    include($default_page);
                }
                else
                {
                    /* Er wordt gekeken of het vrzochte bestand bestaat.
                     */
                    if (file_exists($pag))
                    {
                        /* Zo ja, dan wordt de pagina geladen.
                         */
                        include($pag); 
                    }
                    else
                    {
                        /* Zo niet, dan krijg je een kleine developers joke te zien 
                         */
                        echo "Allan, please add $pag";
                    }
                }
            ?>
        </div>
    </div>
    
    <!-- De footer is het onderste deel van de webpage. Hier worden de validatieknoppen weergeven -->
    <div id="footer" class="banner">
		<a href="http://jigsaw.w3.org/css-validator/validator?uri=https://superinternetshop.nl<?php echo $_SERVER['REQUEST_URI']; ?>">
			<img src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS3" />
		</a>
        <a href="http://validator.w3.org/check?uri=https://superinternetshop.nl<?php echo $_SERVER['REQUEST_URI']; ?>">
			<img src="http://www.w3.org/Icons/valid-xhtml11-blue" alt="Valid XHTML 1.1" />
		</a>
    </div>
</div>

<!--Developers grapje. source:http://snaptortoise.com/konami-js/ -->

<script type="text/javascript" src="//konami-js.googlecode.com/svn/trunk/konami.js"></script>
<script type="text/javascript">
	konami = new Konami()
	konami.load("?pag=42.toad");
</script>


<!-- In verband met de cookie-wet, wordt wanneer de gebruiker nog niet de
     cookie 'user' heeft, een cookiemelding weergeven. -->
<?php
    if (!isset($_COOKIE["user"])) {
?>
    <script type="text/javascript">
        window.onload = alert("Deze website maakt gebruik van functionele cookies. Bij het gebruik van de website gaat u hiermee akkoord.") ;
    </script>
<?php
}
?>

</body>
</html>