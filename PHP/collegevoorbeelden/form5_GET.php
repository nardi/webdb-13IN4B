<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Welcome form</title>
</head>
<body>
<?php
if (!empty($_GET["fname"]) && !empty($_GET["age"]))
{
  $fname = strip_tags($_GET["fname"]);
  $age   = strip_tags($_GET["age"]);
  print "Hello $fname. ";
  print "You're $age years old.";
}
else
{
  print <<<EOT
  <form action="{$_SERVER['PHP_SELF']}" method="get">
    Name: <input type="text" name="fname" />
    Age: <input type="text" name="age" />
    <input type="submit" value="Go!" />
  </form>
EOT;
}
?>
</body>
</html> 
