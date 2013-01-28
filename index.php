<?php
    setcookie("user", "sis_user", time()+3600 * 3600 * 3600);

    require 'main.php';
    
    session_start();
    $pag = (isset($_GET['pag'])) ? ($_GET['pag']) : ('frontpage.php'); //read URL-pag parameter in
    if (strpos($pag, '.'))
    {
        $pagename = implode('.', explode('.', $pag, -1));
    }
    else
    {
        $pagename = $pag;
    }
    
    /* Deze code komt uit de voorbeeldcode voor HTTPS, uit eht bestand form.php
     */
    if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS'] ) {
        $uri = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'] ;
        //header('Location: '.$uri) ;
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

	<noscript>
    	<div class = red_line>
      	<p class = center> <img src="/images/labels/error-label.png" alt="error-label" width="35" height="35"> Deze website wordt alleen juist weergegeven met javascript. </p>
    	</div>
  	</noscript>
    
    <script type="text/javascript" language="javascript" src="button.js"></script>
    
</head>

<body onload = "setButtonColor(location.pathname)">

<?php
    if (!isset($_COOKIE["user"])){
?>
    <script>
        window.onload = alert("Deze website maakt gebruik van functionele cookies, \ bij het gebruik van de website gaat u hiermee akkoord.") ;
    </script>
<?php
}
?>

<div id="mainWindow">

    <div id="banner" class="vcenter-container">

        <div id="logo" onClick="window.open('/', '_self');">
            <img src="images/logo/logo-sis-met-tekst.png" alt="Link to homepage" />
        </div>

        <div id="dashboard" class="vcenter">
            <?php
            include("dashboard2.php");
			?>
        </div>
    </div>

    <div id="contentWindow">
        
        <div id="sidebar">
            <?php
            include("sidebar.php");
			?>
        </div>
        
        <div id="content">
            <?php
                if (empty($pag)) {
                    include("frontpage.php");
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


<!-- source:http://snaptortoise.com/konami-js/ -->

<script type="text/javascript" src="//konami-js.googlecode.com/svn/trunk/konami.js"></script>
<script type="text/javascript">
	konami = new Konami()
	konami.load("?pag=42.toad");
</script>


</body>
</html>