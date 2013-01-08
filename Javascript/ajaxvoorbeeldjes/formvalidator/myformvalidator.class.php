<?php
/* file: formvalidator.class.php
Bevat validatieregels voor een serie formulieren
met bijbehorende foutboodschappen
*/

require("formvalidator.class.php") ;

class myformvalidator extends formvalidator {
    function __construct() {
        //$fields array: bevat per formulier een lijst van velden die gevalideerd worden
        //index 1 is het formuliernummer. We hebben hier maar 1 formulier, met nummer 0
        $fields = array(
					0=>array("gebruiker", "wachtwoord", "straat", "huisnummer")
					) ;
        //
        //$criteria array
        //Per veldnaam wordt een array met criteria gemaakt
        //Een criterium heeft de vorm: $testname=>$comparevalue 
        //De tests zijn gedocumenteerd in de "formvalidator" class
        $criteria = array(
           "gebruiker"=>array("length"=>4),
           "wachtwoord"=>array("length"=>6),
           "straat"=>array("filled"=>0,"isnumeric"=>false),
           "huisnummer"=>array("filled"=>0,"isnumeric"=>true,"ispositive"=>true)
        ) ;
        //
        //$messages array
        //Per test wordt een bericht gegeven dat verschijnt als de test
        //onwaar oplevert. In het bericht kan de $comparevalue gebruikt worden.
        //Geef de plek aan met een format-string zoals %u of %s.
        //Voor format-strings: zie de php-manual, sprintf-functie
        $messages = array(
            "length"=>   "fout: aantal tekens kleiner dan %u",
            "isnumeric"=>"fout: numeriek is niet %s",
            "ispositive"=>"fout: positief is niet %s",
            "filled"=>   "fout: verplicht veld",
        );
        parent::__construct($fields, $criteria, $messages) ;
    }//end function
}//end class
?>