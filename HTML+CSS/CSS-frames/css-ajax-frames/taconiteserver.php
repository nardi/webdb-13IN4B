<?php
//include common constants and functions
include_once 'common.inc.php';

//tell the browser that this doc is xml
header('Content-Type: text/xml');

//viewing errors onscreen sometimes fails with ajax, we must log
ini_set('log_errors', true);
ini_set('error_log', ROOT);

//generate the taconite xml-doc:
?><taconite-root xml:space="preserve">
    <taconite-replace-children 
        contextNodeID="<?php echo $_GET['elementid']; ?>"
        parseInBrowser="true">
            <?php include common_checkFilename($_GET['filename']); ?>
    </taconite-replace-children>
</taconite-root>
