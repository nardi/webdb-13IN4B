<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">

<div class="centered-container">
  <div class="wachtwoord-vergeten">
    <div align="center"> 
  <h1><CENTER><b>Wachtwoord vergeten?</b></CENTER></h1>
  <hr width="100%">
    <br>
    
   
<?php

if (isset($_REQUEST['email'])) {
      $db = connect_to_db();
      // $email //adres = $_POST['e-mailadres']; // db_prepare // bind param ... /fetch
      $sql = $db->prepare("SELECT naam FROM Gebruikers WHERE email = ? LIMIT 1");
      $sql->bind_param("s", $email) ;
      $sql->execute();

      if (!$sql->fetch()) {
        echo "Dit emailadres is niet bij ons geregistreerd." ;
      } else {

      $email = $_REQUEST['email'] ;
      $onderwerp = "Nieuw wachtwoord aanvragen" ;
      $bericht = "Geachte heer / mevrouw,\ Hierbij ontvangt u een email om uw wachtwoord opnieuw in te stellen.\ etc etc" ;
      $from = "noreply@superinternetshop.nl";
      $headers = "From:" . $from;
      mail($email, $onderwerp, $bericht, $headers);
     
      echo "U krijgt zo spoedig mogelijk een email toegestuurd met een link om uw wachtwoord opnieuw in te stellen.";
      }
    }
else {
      
    echo "<div align='justify'>
    Als u uw wachtwoord bent vergeten, vul dan hieronder uw e-mailadres in. 
    U ontvangt dan binnen enkele ogenblikken een e-mail van ons 
    waarmee u een nieuw wachtwoord kunt opgeven. 
    </div><br><br>";
	echo "<form method='post' action='wachtwoordvergeten.php'>
      Email: <input name='email' type='text'><br>
      </textarea><br>
      <input type='submit'>
      </form>";
}
?>
     


      </div>
    </div>
</div>


