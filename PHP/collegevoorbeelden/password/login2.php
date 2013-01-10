<?php
  # Step-by-step log in example.
  # Robert Belleman, University of Amsterdam
  # R.G.Belleman@uva.nl
  #
  # In this version:
  # - HTML form and PHP code merged,
  #
  # Unsafe:
  # - Lets hackers scan usernames with "Unknown user" message!
  # - slightly better to manage, but still difficult
  # - password readable in PHP code
  # - password readable over network

  if (!empty($_POST['username'])) {
    $success = false;

    switch ($_POST['username']) {
      case "robbel":
        # note the triple '='!
        if ($_POST['password'] === "1abcde")
          $success = true;
        break;

      case "admin":
        if ($_POST['password'] === "geheim")
          $success = true;
        break;

      default:
        print("Unknown user.<br />");
        break;
    }

    if ($success)
      print("Login succesful!<br />Click <a href=\"nextpage.html\">here</a> to continue.<br />");
    else
      print("Login incorrect.<br />Click <a href=\"login2.php\">here</a> to try again.<br />");
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
<form method="post" action="login2.php">
Username: <input name="username" type="text"><br />
Password: <input name="password" type="password"><br />
<input type="submit" value="Submit">
</form>
</body>
</html>
EOT;
?>
