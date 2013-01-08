<?php
  # Step-by-step log in example.
  # Robert Belleman, University of Amsterdam
  # R.G.Belleman@uva.nl
  #
  # In this version:
  # - demonstrates SQL injection by defaulting form values,
  # - username and password checked by database,
  # - note change in form action: action="{$_SERVER['PHP_SELF']}",
  #
  # Unsafe:
  # - password readable over network when submitting form
  # - password readable in database
  # - susceptible to SQL injection!

  if (!empty($_POST['username'])) {
    include("opendb.php");

    $success = false;

    # This version demonstrates SQL injection with defaults in form

    $q = "SELECT 1 FROM users1 WHERE username='{$_POST['username']}' AND password='{$_POST['password']}'";

    // This means the query sent to MySQL would be:
    // SELECT 1 FROM users WHERE user='whatever' AND password='' OR '1'
    echo "<pre>";
    echo $q;
    echo "</pre>";

    $result = mysql_query($q);
    if (!$result) {
      die("Invalid query: " . mysql_error());
    }
    $pw = mysql_fetch_row($result);

    if ($pw[0] === "1")
      $success = true;

    if ($success)
      print("Login succesful!<br />Click <a href=\"nextpage.html\">here</a> to continue.<br />");
    else
      print("Login incorrect.<br />Click <a href=\"{$_SERVER['PHP_SELF']}\">here</a> to try again.<br />");

    include("closedb.php");
  }
  else
    # heredoc syntax
    echo <<<EOT
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Please login</title>
</head>
<body>
<h1>Please login</h1>
<form method="post" action="{$_SERVER['PHP_SELF']}">
Username: <input name="username" type="text" value="whatever"><br />
Password: <input name="password" type="text" value="' OR '1"><br />
<input type="submit" value="Submit">
</form>
</body>
</html>
EOT;
?>
