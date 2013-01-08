<?php
  include("query2html.php");

  $dbhost = "localhost";
  $dbuser = "webdb1250";
  $dbpass = "vekust55";
  $connection = mysql_connect($dbhost, $dbuser, $dbpass) or 
               die('Error connecting to mysql');
  mysql_select_db("webdb1250");

  $q = "SELECT naam FROM meisjesnamen WHERE naam LIKE '" . $_GET['q'] . "%' LIMIT 20";
  $q = str_replace("\'", "'", $q);
  $result = mysql_query($q);
  if (!$result) {
    print "<pre>" . $q . "</pre>";
    die('Invalid query: ' . mysql_error());
  }
  query2html($result);
  mysql_close($connection);
?>
