<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">

<div class="centered-container">
  <div class="wachtwoord-vergeten">
    <div align="center"> 
  <h1><CENTER><b>Wachtwoord Resetten</b></CENTER></h1>
  <hr width="100%">
    <br />
    
   
<?php

if (isset($_POST['wachtwoord']))&&
    isset($_POST['wachtwoord_nogmaals'])) {
	  $email = $_POST['email'] ;
	
	  $db = connect_to_db();
      $sql = $db->prepare("SELECT naam FROM Gebruikers WHERE email = ? LIMIT 1");
      $sql->bind_param("s", $email) ;
      $sql->execute();
    
} else {
      
    echo "<div align='justify'>
    Vul hieronder het door u nieuwe gekozen wachtwoord in. 
    </div><br /><br />";
	echo "<form method='post' action='wachtwoord-reset.php'>
      Wachtwoord: <input name='wachtwoord' type='text'><br />
	  Wachtwoord nogmaals: <input name='wachtwoord_nogmaals' type='text'><br />
      </textarea><br>
      <input type='submit'>
      </form>";
}
?>
     


      </div>
    </div>
</div>


