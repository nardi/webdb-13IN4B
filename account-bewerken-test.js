// Code voor ophalen adres
function getAddress(callback, postcode, nummer, toevoeging)
{
    var xhr = new XMLHttpRequest();
    var url = 'adres.php?postcode=' + postcode + '&nummer=' + nummer;
    if (toevoeging && toevoeging != '')
        url += '&toevoeging=' + toevoeging
    xhr.open('GET', url);
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4)
            callback(JSON.parse(xhr.responseText));
    };
    xhr.send();
}

function completeAddress()
{
    var postcode = document.regform.postcode.value;
    var huisnummer = document.regform.huisnummer.value;
    var toevoeging = document.regform.toevoeging.value;
    
    getAddress(function(adresInfo)
    {
        if (adresInfo && !adresInfo.exception)
        {
            document.regform.straat.value = adresInfo.street;
            document.regform.plaats.value = adresInfo.city;
            //document.regform.co.value = adresInfo.latitude + ', ' + adresInfo.longitude;
            //document.regform.wo.value = adresInfo.surfaceArea + 'm2';
        }
        else
        {
            document.regform.straat.value = document.regform.plaats.value = '';
        }
    }, postcode, huisnummer, toevoeging);
}


//http://www.randomsnippets.com/2008/04/01/how-to-verify-email-format-via-javascript/

// Ik heb even je code gecomment omdat de mijne anders ook helemaal niet geladen wordt :)

//function test(){alert("Werken kreng");}
function checkPostcode(){
    var validPostcode = /^[0-9]{4}[\s-]?[a-z]{2}$/i;
    var postcode = document.getElementById('postcode').value;
    var postcodeLabel = document.getElementById('postcode-label');
    if (!validPostcode.test(postcode))
        error(postcodeLabel, 'Dit is geen geldige postcode.');  
    else
        ok(postcodeLabel, 'Dit is een geldige postcode.');
}
function checkNaam(field, label){
    var validNaam = /^[a-z\s\-]{1,256}$/i
    var naam = document.getElementById(field).value;
    var naamLabel = document.getElementById(label);
    if(!validNaam.test(naam))
        error(naamLabel, 'Geen geldige naam.');
    else
        ok(naamLabel);
}
function checkTel(){
    var validTel1 = /^[0-9]{2,4}$/;
    var validTel2 = /^[0-9]{6,8}$/;
    var validTelTot = /^[0-9]{10}$/;
    var fieldVal = document.getElementById('tel').value;
    var fieldVal2 = document.getElementById('tel2').value;
    var telLabel = document.getElementById('tel-label');
    var telNummerTotaal = fieldVal + fieldVal2;
    if(validTel1.test(fieldVal) && validTel2.test(fieldVal2) && validTelTot.test(telNummerTotaal)){
        ok(telLabel, 'Dit is geen geldig telefoon nummer');
    }
    else
        error(telLabel);
}
function checkHuis(){
    var validHuis = /^[0-9]{1,5}$/;
    fieldVal = document.getElementById('huisnummer').value;
    var huisLabel = document.getElementById('huisnummer-label');
    if(validHuis.test(fieldVal)){
        ok(huisLabel);
    }
    else
        error(huisLabel, 'Geen geldig huisnummer.');
        
}
function check(field, divLabel, msg){
    //alert("started");
    var labelPos = document.getElementById(divLabel);
    var fieldVal = document.getElementById(field);
    if(fieldVal==undefined || fieldVal.value==""){
        //alert("NULL!" + fieldVal);
        error(labelPos, msg);
    }
    else{
        //alert("Niet NULL!" + fieldVal);
        ok(labelPos, msg);
        
    }   
}
function checkMail(){
        //alert("derp");
        var validMail=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        var mailFieldVal = document.getElementById('email');
        var labelPos = document.getElementById('email-label');
        if(!validMail.test(mailFieldVal.value) || mailFieldVal.value=="" || !mailFieldVal.value){
            error(labelPos, 'Dit is geen geldig e-mail adres');
        }
        
        else{
            ok(labelPos, 'Dit is een geldig e-mail adres');
        }
}

function verify(field1, field2, divLabel){
    var field1Val = document.getElementById(field1).value;
    var field2Val = document.getElementById(field2).value;
    var labelPos = document.getElementById(divLabel);
    
    if(field1Val != field2Val){
        error(labelPos, 'Velden zijn niet hetzelfd');
    }
    else{
        ok(labelPos, 'Velden zijn hetzelfde.');
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
    isValidForm = false;
}

function submitThisShit(){
    var form = document.getElementById('regformid');
    isValidForm=true;
    checkNaam('voornaam', 'voornaam-label');
    checkNaam('achternaam', 'achternaam-label');
    checkHuis();
    checkPostcode();
    check('straatid', 'straat-label', 'Uw postcode-huisnummer combinatie bestaat niet.');
    checkTel();
    checkMail();
    verify('email','email-bevestigen','email-bevestigen-label');
    check('wachtwoord','wachtwoord-label');
    verify('wachtwoord','wachtwoord-bevestigen','wachtwoord-bevestigen-label');
    
    if(isValidForm){
        document.regform.action="account-bewerken-test.php";
        return true;
    }
    else{
       return false;
    }
}
