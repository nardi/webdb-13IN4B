<html>
<head>
  <title>Hello World in PHP</title>
</head>
<body>
<?php
$fname = htmlspecialchars($_POST["fname"]);
$age   = htmlspecialchars($_POST["age"]);
print "Hello $fname. ";
print "You're $age years old.";
?>
</body>
</html>


