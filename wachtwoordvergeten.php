<!--
Klant komt op deze pagina als hij op "wachtwoord vergeten" klikt in het dashboard.
-->

<div class="centered-container">
<div class="wachtwoord-vergeten">
<div align="right"> 
<h1><CENTER><b>Wachtwoord vergeten?</b></CENTER></h1>
<hr width="100%">
<br />
    
<?php
function show_form() 
{
	echo "<div align='justify'>
		Als u uw wachtwoord bent vergeten, vul dan hieronder uw e-mailadres in. 
		U ontvangt dan binnen enkele ogenblikken een e-mail van ons 
		waarmee u een nieuw wachtwoord kunt opgeven. 
		</div><br /><br />";
	echo "<form method='post' action='wachtwoordvergeten.php'>
		Email: <input name='email' type='text' /><br />
		</textarea><br />
		<input type='submit' value='verstuur' />
		</form>";
}

if (isset($_POST['email'])) {
	
	//naam en id worden opgehaald uit db, tegelijk wordt gekeken of email voorkomt in db
	$email = $_POST['email'] ;
	$db = connect_to_db();
	$sql = $db->prepare("SELECT id, naam, achternaam FROM Gebruikers WHERE email = ? LIMIT 1");
	$sql->bind_param("s", $email) ;
	$sql->bind_result($id, $naam, $achternaam) ;
	$sql->execute();
	
	//Hier wordt getest of er gegevens uit de database gehaald konden worden met de gegeven query.
	//Zo niet, dan betekend dit dat het emailadres nog niet bekend is in ons systeem, en komt
	//de klant bij het formulier om zichzelf te registreren.
	if (!$sql->fetch()) {
	  
		echo "Dit emailadres is niet bij ons geregistreerd, u wordt nu doorgezet naar onze registreerpagina" ;
		?>
		
		<script type="text/JavaScript">
			setTimeout("location.href = '/registratie.html';",3500);
		</script>
		<?php
	
	} else {
	    
		//als emailadres bestaat in db, dan wordt er een token toegevoegd in de db 
	    $sql->free_result();
	    $token = bin2hex(openssl_random_pseudo_bytes(16));
		$pwu = $db->prepare("UPDATE Gebruikers SET wachtwoord_token = '$token' WHERE email = ? LIMIT 1");
		$pwu->bind_param("s", $email);
		$pwu->execute();
		
		//hier wordt de email met een link waarin het token en id variabale in zit verstuurd
		$onderwerp = "Nieuw wachtwoord aanvragen" ;
		$html = '<html>
		<head>
		</head>
		<body>
		Geachte heer / mevrouw '.$naam.' '.$achternaam.',<br /><br />
		
		Hierbij ontvangt u een email om uw wachtwoord opnieuw in te stellen. <br />
		Klik op <a href="https://www.superinternetshop.nl/wachtwoord-reset.php?token=' . $token . '&id=' . $id . '">wachtwoordlink</a> <br />
		via deze link kunt u eenmalig uw wachtwoord aanpassen. <br /><br />
		
		Met vriendelijke groet,
		<br /> <br /> <br />
		<div>
		Stefani Koetsier <br />
		Customer Care Officer <br />
		<b> Super Internet Shop </b> <br />
		<i> Where gaming begins </i> <br />
		contact@superinternetshop.nl
		</div>
		';
		$html .='<div align="left"><img class="displayed" src="superinternetshop.nl/images/logo/logo-sis.png" alt="logo" width="70" height="33">
		</body></html></div>';
		$css = file_get_contents('main.css') ;
		require_once 'email.php';
		//Bovenstaand gedefinieerde variabelen worden gebruikt om de 'leuke_mail()' functie te gebruiken zodat klant een gestylede email ontvangt.
		leuke_mail($email, $onderwerp, $html, $css);
		
		?><div align="center">U krijgt zo spoedig mogelijk een email toegestuurd met een link om uw wachtwoord opnieuw in te stellen.</div><?php
    }
    //als er geen waarden zijn ingevuld, dan wordt het formulier weergegeven 
} else {
	show_form();
}
?>
</div>
</div>
</div>