function setButtonColor(button) {
    if(window.location.hash) && (button == "/overons.php") {
        button = button + window.location.hash;
    }
    document.getElementById(button).style.background = '#08C1FF';
    document.getElementById(button).style.color = '#FFFFFF';
    document.getElementById(button).style.fontWeight="bold";
}