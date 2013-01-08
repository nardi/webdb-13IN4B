<?php
include 'myformvalidator.class.php';
if (isset($_POST['verstuur'])) {
    //formulier is verstuurd via gewone http-post, check of alles goed is
    $v = new myformvalidator() ;
    list($ok, $msg) = $v->validateForm($_POST, 0);  //dit is formulier 0
    if ($ok) {
        //formulier is OK: doe iets met de ge-POST-te waarden
        //...
        //Stuur gebruiker naar nieuwe pagina om succes te melden
        header('Location: geaccepteerd.html');
        exit();
    }
}
else {
    //defaultwaarden, om geen "Notice" meldingen te krijgen
    $msg = array('form0_msg'=>'', 'gebruiker_msg'=>'', 'wachtwoord_msg'=>'', 
        'straat_msg'=>'', 'huisnummer_msg'=>'') ;
    $_POST = array('gebruiker'=>'', 'wachtwoord'=>'', 'straat'=>'', 'huisnummer'=>'') ;
}

//Formulier is niet verstuurd, of is niet OK: presenteer formulier
//Indien niet OK: $_POST bevat huidige invulling en $msg array bevat foutmeldingen!
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>
      AJAX voorbeeldje: validatie terwijl u typt
    </title>
    <script type="text/javascript" src="js/taconite-client.js"></script>
    <script type="text/javascript" src="js/taconite-parser.js"></script>
    <script type="text/javascript">
        var url = "https://websec.science.uva.nl:30443/~kaper/ajaxvoorbeeldjes/formvalidator/formvalidator_taconite.php";
        function validatefield(field, value) {
            var ajaxrq = new AjaxRequest(url); 
            ajaxrq.addNameValuePair("field", field);
            ajaxrq.addNameValuePair("value", value);
            ajaxrq.sendRequest();
        }
        function processform(formnr) {
            var ajaxrq = new AjaxRequest(url);
            ajaxrq.setEchoDebugInfo(true);
            ajaxrq.addFormElements("form"+formnr);
            ajaxrq.addNameValuePair("formnr", formnr);
            ajaxrq.setUsePOST();  //vergelijk method="post" 
            ajaxrq.sendRequest();
        }
    </script>
    <style type="text/css">
        td.msg { color: red }
    </style>
  </head>
  <body>
  <h1>AJAX: Validatie terwijl u typt</h1>

  <form id="form0" method="post" action="myform.php">
  <table width="100%">
  <col width="40px" /><col width="60px" /><col width="*" />
  <tr>
    <td>gebruiker</td>
    <td><input type="text" name="gebruiker" id="gebruiker"
        value ="<?php echo $_POST['gebruiker'] ?>"        
        onblur="validatefield(this.name, this.value)" />
    </td>
    <td id="gebruiker_msg" class="msg"><?php echo $msg['gebruiker_msg'] ?></td>
  </tr>
  <tr>
    <td>wachtwoord</td>
    <td><input type="text" name="wachtwoord" id="wachtwoord"
        value ="<?php echo $_POST['wachtwoord'] ?>"        
        onblur="validatefield(this.name, this.value)" />
    </td>
    <td id="wachtwoord_msg" class="msg"><?php echo $msg['wachtwoord_msg'] ?></td>
  </tr>
  <tr>
    <td>straat</td>
    <td><input type="text" name="straat" id="straat"
        value ="<?php echo $_POST['straat'] ?>"        
        onblur="validatefield(this.name, this.value)" />
    </td>
    <td id="straat_msg" class="msg"><?php echo $msg['straat_msg'] ?></td>
  </tr>
  <tr>
    <td>huisnummer</td>
    <td><input type="text" name="huisnummer" id="huisnummer"
        value ="<?php echo $_POST['huisnummer'] ?>"        
        onblur="validatefield(this.name, this.value)" />
    </td>
    <td id="huisnummer_msg" class="msg"><?php echo $msg['huisnummer_msg'] ?></td>
  </tr>
  <tr>
    <td colspan="3" id="form0_msg" class="msg"><?php echo $msg['form0_msg'] ?></td>
  </tr>
  </table>

  <p>
    <input type="button" name="controle" value="Controle" onclick="processform(0);" />
    <input type="submit" name="verstuur" value="Verstuur" />
  </p>
  </form>

  </body>
</html>