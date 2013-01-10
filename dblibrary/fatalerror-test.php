<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>fatalerror.inc.php test</title>
</head>
<body>
<h1>fatalerror.inc.php test</h1>
<?php
//try the following with DEBUG=TRUE as well as FALSE
include 'fatalerror.inc.php';

//php fatal error: wrong number of arguments
//$arr = array_pad();

//programmer-generated errors
//show_die('Dit is een fout die altijd wordt getoond');
log_die('Dit is een fout die altijd wordt gelogd');
err_die('Dit is een fout die wordt getoond bij DEBUG en anders gelogd');

?>
</body>
</html>
