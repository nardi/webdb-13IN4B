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
        var validMail=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i
        var mailFieldVal = document.getElementById('email').value;
        if(mailFieldVal(validMail) ==-1){
            email-label.style.backgroundImage = "url('images/labels/warning-label.png')";
            email-label.style.title = "Dit is geen geldig e-mail adres";
            email-label.style.backgroundRepeat="no-repeat";
        }
        
        else{
            email-label.style.backgroundImage = "url('images/labels/ok-label.png')";
            email-label.style.title= "Dit is een geldig e-mail adres.";
            email-label.style.backgroundRepeat="no-repeat";
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
        labelPos.style.backgroundRepeat="no-repeat";
    }   
}
