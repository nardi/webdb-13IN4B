<?php
require 'main.php';

$con = connect_to_db();

//Insert name and e-mail
mysql_select_db("webdb13IN4B", $con);
$voornaam=$_POST['voornaam'];
$achternaam=$_POST['achternaam'];
$Land=$_POST['land'];
$Postcode=$_POST['postcode'];
$Huisnummer=$_POST['huisnummer'];
$Geboortejaar=$_POST['geboortejaar'];
$Geboortemaand=$_POST['geboortemaand'];
$Telefoonnummer=$_POST['telefoonnummer'];
$Mobielnummer=$_POST['mobiel nummer'];
$emailadres=$_POST['e-mailadres'];
$wachtwoord=$_POST['wachtwoord'];

$sql="INSERT INTO database_registratie (voornaam, achternaam, land, postcode, huisnummer,
geboortejaar, geboortemaand, telefoonnummer, mobielnummer, e-mailadres, wachtwoord)
VALUES ('$voornaam', '$achternaam', '$land', '$postcode', '$huisnummer', $geboortejaar, $geboortemaand,
$telefoonnummer, $mobiel nummer', '$emailadres', '$wachtwoord')";

$con->query($sql);

$con->close();
?>