<?php
/*
-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
FILE: fatalerror.inc.php
AUTHORS: W. Kaper
DATE: december 2006
STATE: testing

This library handles fatal errors
Programmer-generated fatal errors are treated the same as php fatal-errors.
Showing or logging of the error is decided by the DEBUG constant.

functions: 
log_die($msg), show innocent message, log the $msg message, and die
show_die($msg), show the $msg message in the errdoc, and die    (unsafe)
err_die($msg), decide what to do based on DEBUG constant: log or show

err_die is the one you would normally use.
*/

//configuration
//constants
define('DEBUG', TRUE);
define('APPNAME', 'Autocomplete');
define('WEBMASTER_EMAIL', 'kaper@science.uva.nl');
define('WEBMASTER_EMAIL_LINK', 
	'<a href="mailto:'.WEBMASTER_EMAIL.'">'.WEBMASTER_EMAIL.'</a>');
define('INNOCENTMSG', 'A technical error occurred on '.date('d-m-Y').'.');
define('ERRDOC', 
    '<html>
    <head><title>Error</title></head>
    <body>
    <h1>Error</h1>
    <p>$errmsg</p>
    <p>Please report the error to '.WEBMASTER_EMAIL_LINK.'.</p>
    </body>
    </html>'
);
//php settings
ini_set('display_errors', DEBUG);
ini_set('log_errors', (!DEBUG));
ini_set('error_log', '/home/kaper/myapp.log');
ini_set('error_reporting', E_ALL ^ E_NOTICE);

//the library itself
//$msg (string), the message to be shown or logged

/*
Show fatal error: stop and present $errmsg wrapped in $this->errdoc
Required: constant ERRDOC must contain "$errmsg"
*/
function show_die($msg) {
	if ( strpos(ERRDOC, '$errmsg')===false ) {
		die ('<p>Site-admin: provide a valid ERRDOC</p><p>'.$msg.'</p>') ;
	}
	die ( str_replace('$errmsg',$msg,ERRDOC) ) ;    
}

/*
Log fatal error and show innocent message
*/
function log_die($msg) {
    error_log(APPNAME.' Error: '.$msg);
    show_die(INNOCENTMSG);
}

/*
Show or log the error message, depending on DEBUG constant
This is the function that you would normally use.
*/
function err_die($msg) {
    if (DEBUG) show_die($msg); 
    else log_die($msg);
}
?>