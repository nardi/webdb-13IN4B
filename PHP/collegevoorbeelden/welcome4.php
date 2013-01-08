<html>
<head>
  <title>Hello World in PHP</title>
</head>
<body>
<?php
$fname = strip_tags($_POST["fname"]);
$age   = strip_tags($_POST["age"]);
print "Hello $fname. ";
print "You're $age years old.";
?>
</body>
</html>


