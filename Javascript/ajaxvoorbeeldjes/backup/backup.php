<?php
//AJAX voorbeeld: auto-save
//typwerk wordt bewaard met regelmatige tussenpozen en bij verlaten pagina
include 'mymysqli.class.php' ;

//Check of er een backup op de server staat, indien ja, toon de eerste die je vindt
$onderwerp = ''; //defaults, voor als niets gevonden
$tekst = '';
$mysqli = new mymysqli(true);
$stmt = $mysqli->sprepare("SELECT onderwerp, tekst FROM ajax_berichten WHERE status=0 LIMIT 1");
$stmt->sbind_result2($onderwerp, $tekst);
$stmt->sexecute();
$stmt->sfetch() ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>
      Xajax 2: auto-save
    </title>
    <script type="text/javascript" src="../../dojo/dojo.js"></script>
    <script type="text/javascript">
        dojo.require("dojo.io.*");
        var submitted = false; //status van de pagina: submitted of niet
        var url = 'https://websec.science.uva.nl:30443/~kaper/ajaxvoorbeeldjes/backup/backup.server.php';
        function save(ready) {
            //het formulier bewaren
            if (ready==1) {
                submitted = true;
                document.getElementById('ready').value=1;
            }
            dojo.io.bind({
                url:      url,
                formNode: "form1",
                method:   "post",
                mimetype: "text/javascript",
                load:     function (type, msg, event) { putIntoPlace(msg) },
                error:    function (type, error) { putIntoPlace(error) }
            })  
        }
        function putIntoPlace(msg) {
            document.getElementById('lastsaved').innerHTML = msg;
        }
        function leavepage() {
            //"onunload" handler, wordt uitgevoerd als gebruiker wegsurft of browser sluit
            //zolang pagina niet 'klaar' is
            if (document.getElementById('ready').value==0) {
                window.clearInterval();
                save(0);
            }
        }
        window.setInterval('save(0)',10000);
    </script>
  </head>
  <body onunload="leavepage();">
  <h1>Xajax 2: auto-save</h1>

  <form id="form1" method="post" action="<?php echo $_SERVER["PHP_SELF"];?>">

    <p>Onderwerp:
        <input type="text" name="subject" id="subject"
            value="<?php echo $onderwerp; ?>" />
    </p>

    <p>Bericht: <br />
        <textarea name="message" id="message" rows="20" cols="80"><?php
            echo $tekst;
        ?></textarea>
    </p>

    <p>Melding: <span id="lastsaved">Bericht werd in deze sessie nog niet bewaard</span>.</p>

    <p>
        <input type="hidden" name="ready" id="ready" value="0" />
        <input type="button" value="Klaar!" onclick="save(1);" />
    </p>

  </form>

  </body>
</html>