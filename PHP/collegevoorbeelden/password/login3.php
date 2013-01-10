<?php
  # Step-by-step log in example.
  # Robert Belleman, University of Amsterdam
  # R.G.Belleman@uva.nl
  #
  # In this version:
  # - username and password stored in database,
  # - password obtained from db based on username,
  # - password checked in PHP code.
  #
  # Unsafe:
  # - password readable over network when submitting form
  # - password readable over network when querying db
  # - password readable in database
  # - susceptible to SQL injection!

  if (!empty($_POST['username'])) {
    include("opendb.php");

    $success = false;

    $q = 'SELECT password FROM users1 WHERE username = "' .  $_POST["username"] . '"';
    $result = mysql_query($q);
    if (!$result) {
      die("Invalid query: " . mysql_error());
    }
    $pw = mysql_fetch_row($result);

    if ($_POST['password'] === $pw[0])
      $success = true;

    if ($success)
      print("Login succesful!<br />Click <a href=\"nextpage.html\">here</a> to continue.<br />");
    else
      print("Login incorrect.<br />Click <a href=\"login3.php\">here</a> to try again.<br />");

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
<form method="post" action="login3.php">
Username: <input name="username" type="text"><br />
Password: <input name="password" type="password"><br />
<input type="submit" value="Submit">
</form>
</body>
</html>
EOT;
?>
