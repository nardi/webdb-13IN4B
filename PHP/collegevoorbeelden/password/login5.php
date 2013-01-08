<?php
  # Step-by-step log in example.
  # Robert Belleman, University of Amsterdam
  # R.G.Belleman@uva.nl
  #
  # New in this version:
  # - password hashed into db with MD5().
  #
  # Unsafe:
  # - ...?

  # Switch to SSL connection if necessary.
  # note the two '=' and '@' in the following:
  if (@$_SERVER['HTTPS'] !== 'on')
  {
    # Note: this only works if https is on default port
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirect", true, 301); // 301: "Moved permanently"
    exit();
  }

  if (!empty($_POST['username'])) {
    include("opendb.php");

    $success = false;

    $username = mysql_real_escape_string($_POST['username'], $dbconn);
    $password = mysql_real_escape_string($_POST['password'], $dbconn);
    # Uncomment to quickly insert username/password in db:
    #$q = "INSERT INTO users1 ( username, password ) VALUES " .
    #     "( '$username', '" .
    #     MD5("$password") . "')";
    $q = "SELECT 1 FROM users1 WHERE username='$username' AND password=MD5(\"$password\")";

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
?>
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Please login</title>
</head>
<body>
<h1>Please login</h1>
<form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
Username: <input name="username" type="text"><br />
Password: <input name="password" type="password"><br />
<input type="submit" value="Submit">
</form>
</body>
</html>
