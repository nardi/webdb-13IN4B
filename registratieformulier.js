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
    }, postcode, huisnummer, toevoeging);
}


//http://www.randomsnippets.com/2008/04/01/how-to-verify-email-format-via-javascript/

/* function check(field, divLabel){
    var label-pos = getElementById(divLabel);
    if(document.forms["registratieformulier"][field].value==null){
        labelPos.style.backgroundImage="url('images/labels/warning-label.png')";
        labelPos.title = "Dit veld mag niet leeg zijn";
        labelPos.style.width = "30px";
        labelPos.style.height = "30px";
    }
    else{
        divLabel.style.backgroundImage="url('images/labels/ok-label.png')";
    }   
}
function checkMail(){
        var validMail=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i

        if(document.forms["registratieformulier"]["email"].value(validMail) ==-1){
            email-label.background-image:url('images/labels/warning-label.png');
            email-label.title = "Dit is geen geldig e-mail adres";
        }
        
        else{
            email-label.background-image:url('images/labels/ok-label.png');
        }
}

function verify(field1, field2, divLabel){
    if(document.forms["registratieformulier"][field1].value != document.forms["registratieformulier"][field2]){
        divLabel.background-image:url('images/labels/warning-label.png');
        divLabel.title = "Dit veld mag niet leeg zijn";
    }
    else{
        divLabel.background-image:url('images/labels/ok-label.png');
    }   
} */