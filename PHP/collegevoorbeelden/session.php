<?php
if (!session_start()) {
  print "Session failed to start!<br />";
}

# note the use of a constant:
print "This is session " . SID . "<p />";
print "This is session " . session_id() . "<p />";

if (isset($_SESSION['views'])) {
  $_SESSION['views']++;
} else {
  $_SESSION['views'] = 0;
}

print $_SESSION['views'];
?>


