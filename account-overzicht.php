<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">
<link rel="stylesheet" type="text/css" href="centering.css">
 
<?php
	if ((!isset($_SESSION['logged-in']))) {
	?>
	<pre>

U bent niet ingelogd!

	</pre>
	<?php
	}
	else {
        require 'main.php';

        $db = connect_to_db();

        $accountoverzicht1 = $db->prepare("SELECT naam, achternaam, telefoonnummer, email FROM Gebruikers WHERE id is 2");
        $accountoverzicht1->execute();
        $accountoverzicht1->bind_result($naam, $achternaam, $telefoonnummer, $email);

        $accountoverzicht2 = $db->prepare("SELECT postcode, huisnummer, toevoeging, plaats, straat FROM Adressen WHERE id is 10");
        $accountoverzicht2->execute();
        $accountoverzicht2->bind_result($postcode, $huisnummer, $toevoeging, $plaats, $straat);
?>

<div class="account-overzicht">
  <div align="right"> 
  <h1><center><b>Mijn account</b></center></h1>
    <hr width="100%">
    <center><b>Accountgegevens</b></center>
    <br>
    Voornaam: <input type="text" name="voornaam" disabled value ="$naam"><br>
    Achternaam: <input type="text" name="achternaam" disabled value ="$achternaam"><br>
    Postcode: <input type="text" name="postcode" disabled value ="$postcode"><br>
    Huisnummer: <input type="text" name="huisnummer" disabled value ="$huisnummer"><br>
    Telefoonnummer: <input type="tel" name="telefoonnummer" disabled value ="$telefoonnummer"><br>
    E-mailadres: <input type="email" name="e-mailadres" disabled value ="$email"><br>
    <hr width="100%">
    <center><b>Bestellingen</b></center><br>
    <div align="center"> 
    <a href="bestellingen-lopende.html"><input type="submit"  value="Lopende bestellingen"></a><br>
    <a href="bestellingen-geschiedenis.html"><input type="submit"  value="Bestelgeschiedenis"></a>
    </div>
    <hr width="100%">
    <center><b>Bewerken</b></center><br>
    <div align="center"> 
    <a href="account-wachtwoord-veranderen.html"><input type="submit"  value="Wachtwoord veranderen"></a><br>
    <a href="account-bewerken.html"><input type="submit"  value="Accountgegevens veranderen"></a>
    </div>
    <hr width="100%">
  </div>
</div>

<?php
        $genresql->free_result();
        $db->close();
?>