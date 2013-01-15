
//http://www.randomsnippets.com/2008/04/01/how-to-verify-email-format-via-javascript/
function test(){alert("Werken kreng");}

function check(field, divLabel){
    alert("started");
    var labelPos = document.getElementById(divLabel);
    var fieldVal = document.getElementById(field).value;
    if(fieldVal.value==null){
        alert("NULL!" + fieldVal.value);
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
        var mailFieldVal = document.getElementById('email');
        if(mailFieldVal.value(validMail) ==-1){
            email-label.backgroundImage = "url('images/labels/warning-label.png')";
            email-label.title = "Dit is geen geldig e-mail adres";
        }
        
        else{
            email-label.backgroundImage = "url('images/labels/ok-label.png')";
        }
}

function verify(field1, field2, divLabel){
    var field1Val = document.getElementById(field1).value;
    var field2Val = document.getElementById(field2).value;
    
    if(field1Val != field2Val){
        divLabel.style.backgroundImage = "url('images/labels/warning-label.png')";
        divLabel.title = "Dit veld mag niet leeg zijn";
    }
    else{
        divLabel.style.backgroundImage="url('images/labels/ok-label.png')";
    }   
}