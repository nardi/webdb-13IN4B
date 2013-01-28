<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">

<div class="centered-container">
  <div class="wachtwoord-vergeten">
    <div align="right"> 
  <h1><CENTER><b>Wachtwoord vergeten?</b></CENTER></h1>
  <hr width="100%">
    <br />
    
   
<?php



if (isset($_POST['email'])) {

	  $email = $_POST['email'] ;
      $db = connect_to_db();
      $sql = $db->prepare("SELECT naam FROM Gebruikers WHERE email = ? LIMIT 1");
      $sql->bind_param("s", $email) ;
	  $sql->bind_result($naam) ;
      $sql->execute();

      if (!$sql->fetch()) {
	  
        echo "Dit emailadres is niet bij ons geregistreerd." ;
		
      } else {
	    
	    $sql->free_result();
	    $token = md5($_POST['email'].time()) ;
		$pwu = $db->prepare("UPDATE Gebruikers SET wachtwoord_token = '$token' WHERE email = ? LIMIT 1");
		$pwu->bind_param("s", $email);
		$pwu->execute();
		
		$pwu->free_result();
		$pwu2 = $db->prepare("SELECT id FROM Gebruikers WHERE wachtwoord_token = ? LIMIT 1");
		$pwu2->bind_param("s", $token) ;
		$pwu2->bind_result($id);
		$pwu2->execute();
		$pwu2->fetch();
		
        /*
		$onderwerp = "Nieuw wachtwoord aanvragen" ;
        $bericht = "Geachte heer / mevrouw '$naam',\n\n Hierbij ontvangt u een email om uw wachtwoord opnieuw in te stellen. \n
		Klik op https://www.superinternetshop.nl/wachtwoord-reset.php?token=" . $token . "&id=" . $id . "\n
		via deze link kunt u eenmalig uw wachtwoord aanpassen.\n\n
		Met vriendelijke groet,\n\n
		Stefani Koetsier\n
		Customer Care Agent\n
		Super Internet Shop\n";
        $from = "noreply@superinternetshop.nl";
        $headers = "From:" . $from;
        mail($email, $onderwerp, $bericht, $headers);
		*/
		
		//nieuw stukje
		
		$html = '<html>
		<head>
		</head>
		<body>
		Hierbij ontvangt u een email om uw wachtwoord opnieuw in te stellen. <br />
		Klik op <a href="https://www.superinternetshop.nl/wachtwoord-reset.php?token=' . $token . &id= . $id '">wachtwoordlink</a> <br />
		via deze link kunt u eenmalig uw wachtwoord aanpassen. <br /><br />
		</body>
		</html>';
		$css = file_get_contents('main.css') ;
		require 'email.php';
		leuke_mail($email, $onderwerp, $html, $css);
		
		
     
        echo "U krijgt zo spoedig mogelijk een email toegestuurd met een link om uw wachtwoord opnieuw in te stellen.";
      }
    
} else {
      
    echo "<div align='justify'>
    Als u uw wachtwoord bent vergeten, vul dan hieronder uw e-mailadres in. 
    U ontvangt dan binnen enkele ogenblikken een e-mail van ons 
    waarmee u een nieuw wachtwoord kunt opgeven. 
    </div><br /><br />";
	echo "<form method='post' action='wachtwoordvergeten.php'>
      Email: <input name='email' type='text'><br />
      </textarea><br />
      <input type='submit' value='verstuur'>
      </form>";
}



?>
     


      </div>
    </div>
</div>


