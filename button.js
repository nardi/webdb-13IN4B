function onButtonClick(button) {

    if (!window.location.hash) {
        window.location = button;
    }

    document.getElementById(button).style.background = '#08C1FF';
    document.getElementById(button).style.color = '#FFFFFF';
    document.getElementById(button).style.fontWeight="bold";
    
    
}