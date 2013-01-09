<?php print '<?xml version="1.0"?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta name="Author" content="Wolter Kaper" />
        <title>SIS</title>
        <link rel="stylesheet" type="text/css" href="maincss.css" />
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
            <a href="index.php?pag=frontpage.html">frontpage</a> <br />
            <a href="index.php?pag=overons.html">overons</a> <br />
            <a href="index.php?pag=Registratieformulier.html">Registratieformulier</a> <br />
            <a href="index.php?pag=Wachtwoordvergeten.html">Wachtwoordvergeten</a> <br />
            <a href="index.php?pag=item-description.html">item-description</a> <br />
            <a href="index.php?pag=category.html">category</a> <br />
        </div>
        
        <div id="content">
            <?php
                $pag = (isset($_GET['pag'])) ? ($_GET['pag']) : ('') ; //read URL-pag parameter in
                
                if (
                    $pag=='frontpage.html' ||
                    $pag=='overons.html'  ||
                    $pag=='Registratieformulier.html'  ||
                    $pag=='Wachtwoordvergeten.html'  ||
                    $pag=='category.html'  ||
                    $pag=='item-description.html'
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
