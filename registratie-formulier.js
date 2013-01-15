
//http://www.randomsnippets.com/2008/04/01/how-to-verify-email-format-via-javascript/
function validateForm(){
    var validMail=/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i

    if(document.forms["myForm"]["email"].value(validMail) ==-1);

