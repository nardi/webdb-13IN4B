function onButtonClick(button) {

    document.getElementById(button).style.background = '#08C1FF';
    document.getElementById(button).style.color = '#FFFFFF';
    document.getElementById(button).style.fontWeight="bold";
    
    if (!window.location.hash) {
        window.location = button;
    }
}