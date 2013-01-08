<?php
//dojo-AJAX voorbeeld: opties weergeven terwijl u typt
//Zoek landnamen die beginnen met $_GET['match']
include_once 'mymysqli.class.php' ;
$match = $_GET['match'] . '%' ;
$mysqli = new mymysqli(true);
$stmt = $mysqli->sprepare(
    'SELECT land FROM ajax_landen WHERE land LIKE ?'
);
$stmt->sbind_param1('s', $match);
$stmt->sbind_result1($land);
$stmt->sexecute();
$n = $stmt->snum_rows() ;

//Het resultaat wordt teruggegeven als JSON-string
//Dit is een manier om objecten of arrays te coderen voor verzending.
//Zie http://json.org/         (alternatief voor xml)
$json = '[' ;
if ($n > 0 && $n <= 10) {
    while ($stmt->sfetch() ) {
        $json .= '["'.$land.'", "'.$land.'"], '    ;
    }
}
$json .= ']' ;

echo $json;
?>