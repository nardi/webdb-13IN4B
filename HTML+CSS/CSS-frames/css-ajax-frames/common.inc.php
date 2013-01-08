<?php
//root of this app
define('ROOT', dirname(__FILE__) );
define('PATH', ROOT.'/fragments');

//function to check if filename is safe for inclusion
//it must not be an url and it must not contain a directory path
function common_checkFilename($filename="") {
    if (
        strpos($filename,'http:')===false && 
        strpos($filename, '/')===false
    ) {
        //ok, compose the real path to the doc
        return PATH.'/'.$filename; 
    } 
    else return false; //illegal, do not include
}
?>