<?php
/* 
file:   formvalidator_taconite.php
auteur: wolter kaper
datum:  21 januari 2007
fase:   klaar

Ajax-verzoekjes om velden of formulieren te valideren worden door
dit script beantwoord. 
Het antwoord is een "taconite" xml-document, dat door de taconite
javascript bibliotheek kan worden verwerkt. Dit document bevat instructies
om foutboodschappen op aangewezen plekken (element-ids) neer te zetten
in het formulier.

De validatie wordt gedaan met hulp van "myformvalidator.class.php"
waarin je de formulier-specifieke validatieregels definieert.
Deze gebruikt zelf weer de algemene "formvalidator.class.php"
*/

include 'myformvalidator.class.php' ;

if (isset($_GET['field']) && isset($_GET['value'])) {
    //Er is om validatie van een enkel veld gevraagd
    header('Content-Type: text/xml') ;
    echo validateField($_GET['field'], $_GET['value']) ;
}
else if (isset($_POST['formnr'])) {
    //Er is om validatie van een heel formulier gevraagd
    header('Content-Type: text/xml') ;
    echo validateForm($_POST, $_POST['formnr']) ;
}
else {
    //Invalide verzoek
    header('Content-Type: text/plain') ;
    echo 'Niet de juiste parameters ontvangen. Exit.' ;
}

// functie definities:

/* Valideer een veld-waarde combinatie
en stuur bericht naar een bij dat veld horend html element
*/
function validateField($field, $value) {
    $v = new myformvalidator() ;
    $msg = $v->validateField($field, $value) ;
    return taconitedoc(
        taconitereplacechildren($field.'_msg', $msg)
    );
}

/* Valideer een via ajax (taconite biebliotheek) gepost form
en stuur bericht naar alle elementen die een bericht verwachten,
d.i. voor elk invoerelement 1 en nog 1 voor het form als geheel
*/
function validateForm($values, $formnr) {
    $v = new myformvalidator() ;
    list($valid, $messages) = $v->validateForm($values, $formnr);
    $content = '';
    foreach ($messages As $targetelement => $msg) {
        //de formvalidator kent de conventie van '_msg' achtervoegsels
        $content .= taconitereplacechildren($targetelement, $msg) ;
    }
    return taconitedoc($content) ;
}

/* Maak een compleet taconite xml-document
$content: (string) een opeenvolging van valide taconite elementen
Deze functie voegt verplichte starttag en eindtag toe
*/
function taconitedoc($content) {
    return '<taconite-root xml:space="preserve">'.
        $content.
        '</taconite-root>' ;
}

/* Maak een taconite-replace-children element
$parentid:    (string) id van het element waarvan kinderen vervangen worden
$newchildren: (string) tekst, of html-elementen, of beide die de eerdere kinderen vervangen
In deze toepassing wordt de foutmelding als platte tekst doorgegeven!
*/
function taconitereplacechildren($parentid, $newchildren) {
    return '<taconite-replace-children'.
        ' contextNodeID="'.$parentid.'"'.
        ' parseInBrowser="true">'.
        $newchildren.
        '</taconite-replace-children>' ;
}
?>