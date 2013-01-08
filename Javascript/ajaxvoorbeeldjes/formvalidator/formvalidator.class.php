<?php
// formvalidator.class.php
//
// Vereisten aan de formulierpagina:
// - De pagina bevat 1 of meer forms met ids: "form0", "form1", ...
// - Bij elk form hoort een element met id: "form0_msg", "form1_msg"
//   om foutberichten voor het form als geheel neer te zetten
// - Bij elke input met naam en id $input hoort een element met id ${input}_msg
//   om foutbericht specifiek voor die input neer te zetten
//
// Schrijf per formulier of per serie formulieren
// een subklasse "myformvalidator" waarin je de veldnamen, de criteria en de
// messages definieert. Zie het "myformvalidator" voorbeeld.

define('FIELD_OK', 'OK') ;
define('FORM_OK', 'Alle velden OK') ;
define('FORM_BAD','Een of meer velden zijn niet correct ingevuld') ;
define('CRITERION_BAD', 'Formvalidator: Fout in criteria, exit') ;

class formvalidator {
    protected $fields;      //string array[][]
        //per formulier een rij veldnamen: velden die controle krijgen
        //eerste index: formuliernummer, tweede index: veldnummer
    protected $criteria;   //hash[][]
        //$this->criteria[$fieldname][$testname] = comparevalue
    protected $messages;   //string hash
        //bericht bij falen van test, met $testname als key

    public function __construct($fields, $criteria, $messages) {
        $this->fields   = $fields ;
        $this->criteria = $criteria ;
        $this->messages = $messages ;
    }

    //Valideer alle verwachte velden in $values associatief array
    //$values, (string fieldname => mixed value)
    //$formnr, (integer) identificeer het formulier
    public function validateForm($values, $formnr) {
        $valid = TRUE ;  //nog geen fouten gevonden
        $response = array();
        foreach ($this->fields[$formnr] As $field) {
            $value = (isset($values[$field]) ) ? ($values[$field]) : ("") ;
            $msg = $this->validatefield($field, $value, $response) ;
            $response[$field.'_msg'] = $msg ;
            $valid &= (($msg==FIELD_OK) ? (TRUE) : (FALSE)) ;
        }
        $response["form".$formnr."_msg"] = ($valid) ? (FORM_OK) : (FORM_BAD) ;
        return array($valid, $response) ;
    }

    //Valideer een veld
    //$field (string) veldnaam
    //$value (mixed) waarde
    public function validateField($field, $value) {
        $valid = TRUE ;  //nog geen fouten gevonden
        $message = "" ;
        foreach($this->criteria[$field] As $test => $comparevalue) {
            $ok = $this->doTest($test, $value, $comparevalue) ;
            $valid &= $ok ;
            $message.= ($ok) ? 
                ("") :
                (sprintf(
                    $this->messages[$test], $this->boolToStr($comparevalue) 
                ).", ") ;
        }
        $message = ($valid) ?
            (FIELD_OK) :
            ( substr($message, 0, strlen($message)-2) ) ; //laatste komma eraf
        return $message ;
    }
		
    private function boolToStr($var) {
        //als $var een boolean is, dan maken we een nederlandse string
        return (is_bool($var) ) ?
            (($var) ? ("waar") : ("onwaar")) :
            ($var) ;
    }

	private function doTest($test, $value, $comparevalue) {
        //declareer hieronder de mogelijke tests
        switch ($test) {
            case 'length'    : return $this->length($value, $comparevalue); break;
			case 'isnumeric' : return $this->isnumeric($value, $comparevalue); break;
			case 'ispositive': return $this->ispositive($value, $comparevalue); break;
			//bij sommige tests wordt de $comparevalue genegeerd
			case 'filled'    : return $this->filled($value); break;
			case 'isdate'    : return $this->isdate($value); break;
			case 'isemail'   : return $this->isemail($value); break;
			case 'isurl'     : return $this->isurl($value); break;
			default : die(CRITERION_BAD);
		}
	}

    //Hieronder volgen de tests.
    //Dit is uitbreidbaar: zie doTest hierboven

    //test: string lengte > crit?
    private function length($value, $crit) {
        if (! is_numeric($crit) ) die(CRITERION_BAD);
        return (strlen($value)>= $crit ) ?
            (TRUE) : (FALSE) ;
    }

    //test: numeriek, of juist niet?
    private function isnumeric($value, $crit) {
        if (! is_bool($crit) ) die(CRITERION_BAD);
        return (is_numeric($value)===$crit) ? 
            (TRUE) : (FALSE) ;
    }
		
	//test: positief, of juist niet?
	private function ispositive($value, $crit) {
        if (! is_bool($crit) ) die(CRITERION_BAD);
        return ((is_numeric($value) && $value > 0)===$crit) ?
            (TRUE) : (FALSE) ;
    }
		
    //tests zonder comparevalue
		
    //test filled
	private function filled($value) {
        return (strlen($value)>= 1 ) ?
            (TRUE) : (FALSE) ;
    }
		
    //test: string is geformatteerd volgens "d-m-yyyy"
    //en stelt een geldige datum voor?
    //sorry, nog niet land-onafhankelijk (PHP4 compatibel)
    private function isdate($value) {
        $date = explode("-", $value) ;
        $d=$date[0]; $m=$date[1]; $y=$date[2];
        return (checkdate($m, $d, $y) ) ?
            (TRUE) : (FALSE) ;
    }
		
    //volgende twee tests zijn niet echt goed

    //test: email heeft format x@y.z, 
    //waar x, y en z strings zijn zonder @ maar eventueel wel met .
    private function isemail($value) {
        $email = explode("@", $value) ;
        if (count($email)==2 ) {
            $domain = $email[1] ;
            $domain = explode(".",$domain) ;
            return (count($domain) >= 2) ? (TRUE) : (FALSE) ; 
        }
        else return FALSE;
	}
		
    //test: url heeft format x.y  -- echt suf.
    private function isurl($value) {
        $url = explode(".",$value) ;
        return (count($url) >= 2) ? 
            (TRUE) : (FALSE) ; 
    }
}
?>