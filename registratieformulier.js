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
        if (!adresInfo.exception)
        {
            document.regform.straat.value = adresInfo.street;
            document.regform.plaats.value = adresInfo.city;
            document.regform.co.value = adresInfo.latitude + ', ' + adresInfo.longitude;
            document.regform.wo.value = adresInfo.surfaceArea + 'm2';
        }
        else
        {
            document.regform.straat.value = document.regform.plaats.value = '';
        }
    }, postcode, huisnummer, toevoeging);
}


//http://www.randomsnippets.com/2008/04/01/how-to-verify-email-format-via-javascript/

// Ik heb even je code gecomment omdat de mijne anders ook helemaal niet geladen wordt :)

function test(){alert("Werken kreng");}

function check(field, divLabel){
    //alert("started");
    var labelPos = document.getElementById(divLabel);
    var fieldVal = document.getElementById(field).value;
    if(fieldVal==null || fieldVal==""){
        //alert("NULL!" + fieldVal);
        labelPos.style.backgroundImage="url('images/labels/warning-label.png')";
        labelPos.title = "Dit veld mag niet leeg zijn";
        labelPos.style.backgroundRepeat="no-repeat";
    }
    else{
        //alert("Niet NULL!" + fieldVal);
        labelPos.style.backgroundImage="url('images/labels/ok-label.png')";
        labelPos.style.title = "Dit veld is goed ingevuld.";
        labelPos.style.backgroundRepeat="no-repeat";
        
    }   
}
function checkMail(){
        //alert("derp");
        var validMail=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i
        var mailFieldVal = document.getElementById('email');
        var labelPos = document.getElementById('email-label');
        if(!validMail.test(mailFieldVal.value) || mailFieldVal.value=="" || !mailFieldVal.value){
            labelPos.style.backgroundImage = "url('images/labels/warning-label.png')";
            labelPos.title = "Dit is geen geldig e-mail adres";
            labelPos.style.backgroundRepeat="no-repeat";
        }
        
        else{
            labelPos.style.backgroundImage = "url('images/labels/ok-label.png')";
            labelPos.style.title= "Dit is een geldig e-mail adres.";
            labelPos.style.backgroundRepeat="no-repeat";
        }
}

function verify(field1, field2, divLabel){
    var field1Val = document.getElementById(field1).value;
    var field2Val = document.getElementById(field2).value;
    var labelPos = document.getElementById(divLabel);
    
    if(field1Val != field2Val){
        labelPos.style.backgroundImage = "url('images/labels/warning-label.png')";
        labelPos.title = "Dit veld mag niet leeg zijn";
        labelPos.style.backgroundRepeat="no-repeat";
    }
    else{
        labelPos.style.backgroundImage="url('images/labels/ok-label.png')";
        labelPos.title="E-mailadressen zijn niet hetzelfde.";
        labelPos.style.backgroundRepeat="no-repeat";
    }   
}
