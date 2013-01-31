function onButtonclick(button) {
    if (!button)
        button = '';
    window.location = '/' + button;
}


function setButtonColor(button) {
    if(button) {
        document.getElementById(button).style.background = '#08C1FF';
        document.getElementById(button).style.color = '#FFFFFF';
        document.getElementById(button).style.fontWeight="bold";   
    }
}