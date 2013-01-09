<?php print '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="Author" content="Wolter Kaper" />
        <title>SIS</title>
<style type="text/css">

html {
    overflow: scroll;
}

html, body {
    margin : 0;
    height : 100%;
    width : 100%;
}

#mainWindow {
    height : 100%;
    width : 60em;
    margin-left : auto;
    margin-right : auto
}

#banner {
    height : 10%;
    width : 100%;
    
}

#logo {
    float : left;
    width : 40em;
}
    
#dashboard {
    float : left;
}


#contentWindow {
    width : 100%;
}

#sidebar {
    float : left;
    width : 12em;
}

#content {
    overflow : hidden;
}







</style>
</head>

<body>

<div id="mainWindow">

    <div id="banner">

        <div id="logo">
            S.I.S logo hier!
        </div>

        <div id="dashboard">
            Inloggen en zooi gebeurt hier. 
        </div>

    </div>

    <div id="contentWindow">

        <div id="sidebar">
            Hoi <br />
            Hier <br />
            Komen <br />
            Items <br />
            <a href="index.php?pag=frontpage.html">Nardi's frontpage.</a>
            <a href="index.php?pag=ItemDescription.html">Bas's I.D.</a>
        </div>
        
        <div id="content">
            <?php
                $pag = (isset($_GET['pag'])) ? ($_GET['pag']) : ('') ; //read URL-pag parameter in
                
                if (
                    $pag=='frontpage.html' ||
                    $pag=='jantje.txt'  ||
                    $pag=='pietje.txt'
                ){
                //a legal file is requested, serve it up
                    include($pag) ; //fetch the file and replace '<?php ... by its contents
                }

                else {
                //an illegal file is requested; serve an innocent default instead
                    include("frontpage.html");
                }
            ?>
            
          
        </div>
    </div>
</div>










<!--

<div class="topwindow">
                 Probeer deze: &nbsp;
                 <a href="CSS-php-frames.php?pag=jantje.txt">Hyperlink 1</a> &nbsp;
                 <a href="CSS-php-frames.php?pag=pietje.txt">Hyperlink 2</a> &nbsp;
                 <a href="CSS-php-frames.zip">Download code</a>
</div>

<div class="contentWindow"> 
                 

</div> -->

</body>
</html>
