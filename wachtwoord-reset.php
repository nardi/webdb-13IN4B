<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">

<div class="centered-container">
  <div class="wachtwoord-vergeten">
    <div align="right"> 
  <h1><CENTER><b>Wachtwoord Resetten</b></CENTER></h1>
  <hr width="100%">
    <br />
    
   
<?php

if (!isset($_POST['wachtwoord'])&&
	!isset($_POST['wachtwoord_nogmaals'])) {
	
	$db = connect_to_db();
    $token = ($_GET['token']);
    $sql3 = $db->prepare("SELECT id FROM Gebruikers WHERE wachtwoord_token = ? LIMIT 1");
	$sql3->bind_param("s", $token) ;
	$sql3->bind_result($token_valid);
	$sql3->execute();

	if (!is_null($token_valid)) {
	
		$token = ($_GET['token']);  
		echo "<div align='justify'>
		Vul hieronder het door u nieuwe gekozen wachtwoord in. 
		</div><br /><br />";
		echo "<form method='post' action='wachtwoord-reset.php'>
		  <input name='token' type='hidden' value='$token'>
		  Wachtwoord: <input name='wachtwoord' type='text'><br />
		  Wachtwoord nogmaals: <input name='wachtwoord_nogmaals' type='text'><br />
		  </textarea><br />
		  <input type='submit'>
		  </form>";
	
	} else {
		
		throw new Exception("Deze link is verlopen") ;
	}
	
	  
} else {
	
	if ($_POST['wachtwoord'] === $_POST['wachtwoord_nogmaals']) {
	  $token = $_POST['token'] ;
	  $wachtwoord = $_POST['wachtwoord_nogmaals'] ;
	  
	  //Random getal voor salt genereren
	  $saltbytes = openssl_random_pseudo_bytes(32);
	  $salt = bin2hex($saltbytes);
	
	  //Hashen met SHA-256
	  $wwhash = hash('sha256', $wachtwoord);
	  $saltedwwhash = hash('sha256', $salt . $wwhash);
	
	  //Combinatie salt en wachtwoordhash voor database
	  $saltww = $salt . $saltedwwhash;
	
	  //Hier wordt het wachtwoord naar de database geschreven
	  $db = connect_to_db();
	  $sql = $db->prepare("UPDATE Gebruikers SET wachtwoord = '$saltww' WHERE wachtwoord_token = ? LIMIT 1");
	  $sql->bind_param("s", $token) ;
	  $sql->execute();
	  
	  //Hier wordt de token verwijderd uit de database
	  $sql2 = $db->prepare("UPDATE Gebruikers SET wachtwoord_token = '0' WHERE wachtwoord_token = ? LIMIT 1");
	  $sql2->bind_param("s", $token) ;
	  $sql2->execute();
	  echo "Uw wachtwoord is aangepast, hartelijk dank!" ;
	  
	} else {
		$token = $_POST['token'] ;
		  
		echo "<div align='justify'>
		Vul hieronder nogmaals het door u nieuwe gekozen wachtwoord in. 
		</div><br /><br />";
		echo "<form method='post' action='wachtwoord-reset.php'>
		  <input name='token' type='hidden' value='$token'>
		  Wachtwoord: <input name='wachtwoord' type='text'><br />
		  Wachtwoord nogmaals: <input name='wachtwoord_nogmaals' type='text'><br />
		  </textarea><br />
		  <input type='submit'>
		  </form>"; 
	  
	}
	  
} 
	  
?>
    
      </div>
    </div>
</div>


