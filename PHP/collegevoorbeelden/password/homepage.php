<?php
  # must do this before any output is produced;
  # enable sessions
  session_start();
?>

<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>Home</title>
</head>
<body>
<h1>Welcome to the homepage</h1>
<?php
if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {
  print "You are logged in!<br />";
} else {
  die("You must <a href=\"login7.php\">log in</a> first!<br />");
}
?>

<p align="right"><b><a href="logout.php">Log out</a></b></p>

Here's the rest of the site ...
Here's the rest of the site ...
Here's the rest of the site ...
Here's the rest of the site ...
Here's the rest of the site ...
Here's the rest of the site ...
Here's the rest of the site ...
</body>
