<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">

<div class="centered-container">
  <div class="wachtwoord-vergeten">
    <div align="center"> 
  <h1><CENTER><b>Wachtwoord Resetten</b></CENTER></h1>
  <hr width="100%">
    <br />
    
   
<?php

if (isset($_GET['token'])) {
    

    if (!isset($_POST['wachtwoord'])&&
	    !isset($_POST['wachtwoord'])) {

    $token = ($_GET['token']);  
    echo "<div align='justify'>
    Vul hieronder het door u nieuwe gekozen wachtwoord in. 
    </div><br /><br />";
	echo "<form method='post' action='wachtwoord-reset.php'>
	  
      Wachtwoord: <input name='wachtwoord' type='text'><br />
	  Wachtwoord nogmaals: <input name='wachtwoord_nogmaals' type='text'><br />
      </textarea><br>
      <input type='submit'>
      </form>";
	  
    } else {
	  
	  $wachtwoord = $_POST['wachtwoord_nogmaals'] ;
	  
	  //Random getal voor salt genereren
      $saltbytes = openssl_random_pseudo_bytes(32);
      $salt = bin2hex($saltbytes);
    
      //Hashen met SHA-256
      $wwhash = hash('sha256', $wachtwoord);
      $saltedwwhash = hash('sha256', $salt . $wwhash);
    
      //Combinatie salt en wachtwoordhash voor database
      $saltww = $salt . $saltedwwhash;
	
	  $db = connect_to_db();
      $sql = $db->prepare("UPDATE Gebruikers SET wachtwoord = '$saltww' WHERE wachtwoord_token = ? LIMIT 1");
      $sql->bind_param("s", $token) ;
      $sql->execute();
	  echo "Uw wachtwoord is aangepast, hartelijk dank!" ;
	  
    

   
    

}
}

	  
	  
?>
    
      </div>
    </div>
</div>


