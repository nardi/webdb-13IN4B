function submitChanges(){
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
        document.regform.action="account-bewerken.php";
        return true;
    }
    else{
       return false;
    }
}