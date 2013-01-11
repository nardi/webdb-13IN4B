<?php
require 'main.php';

$con = connect_to_db();

//Insert name and e-mail
$voornaam=$_POST['voornaam'];
$achternaam=$_POST['achternaam'];
$land=$_POST['land'];
$postcode=$_POST['postcode'];
$huisnummer=$_POST['huisnummer'];
$geboortedatum=$_POST['jaar']. '-' . $_POST['maand'] . '-' . $_POST['dag'];
$telefoonnummer=$_POST['telefoonnummer'];
$mobielnummer=$_POST['mobielnummer'];
$emailadres=$_POST['e-mailadres'];
$wachtwoord=$_POST['wachtwoord'];
$dateOfRegistration=date('Y-m-d');

$sql="INSERT INTO database_registratie (voornaam, achternaam, land, postcode, huisnummer,
geboortedatum, telefoonnummer, mobielnummer, emailadres, wachtwoord, RegistratieDatum)
VALUES ('$voornaam', '$achternaam', '$land', '$postcode', '$huisnummer', '$geboortedatum',
'$telefoonnummer', '$mobielnummer', '$emailadres', '$wachtwoord', '$dateOfRegistration')";

/*
    Zo moet error-handlen:
    if (!$con->query(...))
        throw new Exception($con->error);

    of met resultaat:
    $res = $con->query(...)
    
    if (!$res)
        throw new Exception($con->error);
    
    of:
    if (!$res = $con->query(...)) (misschien, weet niet)
        throw new Exception($con->error);
*/

if(!$con->query($sql)){
    throw new Exception($con->error);
    }
    


$con->close();

window.open('index.php?pag=registratie-succesvol.html', '_self');

?>
