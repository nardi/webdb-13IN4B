
//http://www.randomsnippets.com/2008/04/01/how-to-verify-email-format-via-javascript/
function test(){alert("Werken kreng!");}

function check(field, divLabel){
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

function verify(field 1, field2, divLabel){
    if(document.forms["registratieformulier"][field1].value != document.forms["registratieformulier"][field2]){
        divLabel.background-image:url('images/labels/warning-label.png');
        divLabel.title = "Dit veld mag niet leeg zijn";
    }
    else{
        divLabel.background-image:url('images/labels/ok-label.png');
    }   
}