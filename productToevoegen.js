function checkTekst(field, label){
    var validTekst = /^[a-z\s\-\,\?\!\'\"\:\;0-9]{1,10000}$/i;
    var tekst = document.getElementById(field).value;
    var label = document.getElementById(label);
    
    if(!validTekst.test(tekst)){
        error(label, 'Dit veld is niet goed ingevuld');
    }
    
    else{
        ok(label);
    }
    
}

function checkPrijs(field, label){
    var validPrijs =/^[0-9]+$/;
    var prijs = document.getElementById(field).value;
    var label = document.getElementById(label);
    if(!validPrijs.test(prijs)){
        error(label, 'Dit veld is niet goed ingevuld.');
    }
    else{
        ok(label);
    }
}
//Er moet even gekeken worden naar wat er gebeurt als een datum als dd-mm-jjjj wordt ingevoerd.
function checkDatum(field, label){
    var validDatum = /^[0-9]{4}[\-][0-9]{2}[\-][0-9]{2}$/;
    var datum = document.getElementById(field).value;
    var label = document.getElementById(label);
    
    if(!validDatum.test(datum)){
        error(label, 'Geen geldige datum.');
    }
    
    else{
        ok(label);
    }
}

//Er moet een NULL waarde worden bijggevoegd.
function checkDropdown(field, label){
    var dropdown = document.getElementById(field).value;
    var label = document.getElementById(label);
    if(dropdown == ""){
        error(label, 'Geef een geldige keuze op.');
    }
    else{
        ok(label);
    }
}

//Alleen waarschuwing, cover is niet verplicht.
function checkCover(field, label){
    var cover = document.getElementById(field).value;
    var label = document.getElementById(label);
    if(cover==""){
        error(label, 'U heeft geen cover opgegeven. Klopt dit wel?');
    }
}

function ok(labelPos, msg){
    var melding;
    if(msg==undefined)
        melding = "Dit veld is correct ingevuld.";
    else
        melding = msg;
        
    labelPos.style.backgroundImage="url('images/labels/ok-label.png')";
    labelPos.title = melding;
    labelPos.style.backgroundRepeat="no-repeat";
}
var isValidForm = true;
function error(field, msg){
    var labelPos = field;
    var melding;
    if(msg==undefined)
        melding = "Dit veld mag niet leeg zijn.";
    else
        melding = msg;
        
    labelPos.style.backgroundImage = "url('images/labels/warning-label.png')";
    labelPos.title = melding;
    labelPos.style.backgroundRepeat="no-repeat";
    if (field != document.getElementById('coverlabel')){
        isValidForm = false;
    }
}

function testall(){
    isValidForm = true;
    checkTekst('titel','titellabel');
    checkTekst('beschrijving','beschrijvinglabel');
    checkPrijs('prijs', 'prijslabel');
    checkDatum('release_date','releaselabel');
    checkPrijs('voorraad','voorraadlabel');
    checkDropdown('platform','platformlabel');
    checkDropdown('genre','genrelabel');
    checkCover('image','coverlabel');
    
    if(isValidForm){
        document.toevoegform.action="product-toevoegen-db.php";
        return true;
    }
    else{
       return false;
    }
}

function emptydate(){
    var date= document.getElementById('release_date');
    date.value = "";
}