<?php
require 'main.php';

$con = connect_to_db();

$sql = "INSERT INTO db_test_php (Voornaam, Achternaam, E-mail adres) 
VALUES ($_POST['voornaam'],$_POST['achternaam'],$_POST['e-mailadres'])";

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

$con->query($sql);

$con->close();
?>