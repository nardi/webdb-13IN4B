function onButtonclick(button) {
    if (!button)
        button = '';
    window.location = '/' + button;
}


function setButtonColor(button) {
    var buttonObject = document.getElementById(button);
    if(buttonObject != null) {
        buttonObject.style.background = '#08C1FF';
        buttonObject.style.color = '#FFFFFF';
        buttonObject.style.fontWeight="bold";   
    }
}