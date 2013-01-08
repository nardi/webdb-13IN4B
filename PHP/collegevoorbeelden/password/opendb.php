<?php
  # move this configuration file out of the web server's range!!!
  $dbconf = simplexml_load_file("mysql_config.xml");
  if ($dbconf === FALSE) {
    die("Error parsing XML file");
  }
  else {
    $dbconn = mysql_connect($dbconf->mysql_host,
                            $dbconf->mysql_username,
                            $dbconf->mysql_password)
                  or die('Error connecting to mysql server');
    mysql_select_db($dbconf->mysql_database);
  }
?>
