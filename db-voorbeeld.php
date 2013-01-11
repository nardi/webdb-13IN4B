<?php
require 'main.php';

$con = connect_to_db();

$sql = "INSERT INTO db_test_php (Voornaam, Achternaam, E-mail adres) 
VALUES ($_POST['voornaam'],$_POST['achternaam'],$_POST['e-mailadres'])";

$con->query($sql);

$con->close();
?>