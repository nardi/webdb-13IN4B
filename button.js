function onButtonclick(button) {
    if (!button)
        button = '';
    window.location = '/' + button;
}


function setButtonColor(button) {
    var buttonObject = document.getElementById(button);
    if(buttonObject != null) {
        document.getElementById(button).style.background = '#08C1FF';
        document.getElementById(button).style.color = '#FFFFFF';
        document.getElementById(button).style.fontWeight="bold";   
    }
}