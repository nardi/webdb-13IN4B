<html>
<head>
<title>
Reading data from webform
</title>
</head>
<body>
<h1>
Reading data from webform
</h1>
You entered:
<table border="1" cellpadding="5">
<?php
foreach ($_REQUEST as $key => $value) {
  echo "<tr><td>$key</td><td>$value</td></tr>";
}
?>
</table>
</body>
</html>