<?php
$con = mysql_connect("sisv2.tk","webdb13IN4B","trestunu");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

//Insert name and e-mail
mysql_select_db("webdb13IN4B", $con);
$sql = "INSERT INTO db_test_php (Voornaam, Achternaam, E-mail adres) 
VALUES ($_POST['voornaam'],$_POST['achternaam'],$_POST['e-mailadres'])";


// Execute query
mysql_query($sql,$con);

mysql_close($con);
?>