function submitAddress(){
    var form = document.getElementById('regformid');
    isValidForm=true;
    checkHuis();
    checkPostcode();
    check('straatid', 'straat-label', 'Uw postcode-huisnummer combinatie bestaat niet.');
    
    if(isValidForm){
        document.getElementById'regformid'.action="adres-toevoegen.php";
        return true;
    }
    else{
       return false;
    }
}
