<?php
if (!isset($_COOKIE['views'])) {
  setcookie("views", "0", time() + 10);
}

print "<pre>";
var_dump($_COOKIE);
print $_COOKIE['views'];
print "</pre>";
?>
