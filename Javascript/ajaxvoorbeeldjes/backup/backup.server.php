<?php
/* file: backup.sever.php
Bewaart backups van via ajax gesubmitte forms.
Zodra de gebruiker aangeeft klaar te zijn, wordt hij naar andere pagina gebracht

Het type document is in alle gevallen: text/javascript.
Dit is handig om de redirect te kunnen doen.
*/

include 'mymysqli.class.php';
header('Content-Type: text/javascript');

$mysqli = new mymysqli(true);
$subject = $_POST['subject'] ;
$message = $_POST['message'] ;
$status = (
    isset($_POST['ready']) && $_POST['ready']
    ) ? 
    (1) : (0) ;
$stmt = $mysqli->sprepare("REPLACE ajax_berichten SET onderwerp=?, tekst=?, status=?") ;
$stmt->sbind_param3('ssi', $subject, $message, $status);
$stmt->aexecute();

$time = date('H:i:s',time()) ;
$melding = ($stmt->saffected_rows() > 0) ?
    ('Laatst bewaard op: '.$time) :
    ('Fout: '.$time.', bewaren mislukt!') ;

if ($status==1 && $stmt->saffected_rows() > 0) {
    //Klaar! Stuur gebruiker naar volgende pagina met javascript
    echo "window.location.href='geplaatst.html';"; 
}
else {
    //Nog bezig, of fout: Retourneer $melding naar pagina als 
    //evalueerbare "javascript-waarde" (JSON)
    echo '"'.$melding.'"';   //de " zijn javascript!     
}
?>