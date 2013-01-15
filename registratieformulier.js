
//http://www.randomsnippets.com/2008/04/01/how-to-verify-email-format-via-javascript/
function check(field, div-label){
    if(document.forms["registratieformulier"][field].value==null){
        div-label.background-image:url('images/labels/warning-label.png');
        div-label.title = "Dit veld mag niet leeg zijn";
    }
    else{
        div-label.background-image:url('images/labels/ok-label.png');
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

function verify(field 1, field2, div-label){
    if(document.forms["registratieformulier"][field1].value != document.forms["registratieformulier"][field2]){
        div-label.background-image:url('images/labels/warning-label.png');
        div-label.title = "Dit veld mag niet leeg zijn";
    }
    else{
        div-label.background-image:url('images/labels/ok-label.png');
    }   
}