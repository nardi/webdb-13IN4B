/* onButtonClick laad een pagina aan de hand op welke knop in de sidebar wordt
 * gedrukt.
 */
function onButtonclick(button) {
    if (!button)
        button = '';
    window.location = '/' + button;
}

/* De setButtonColor functie kijkt of de beklikte div een knop in de sidebar is.
 * Zo ja, dan wordt deze knop ge-highlight.
 */
function setButtonColor(button) {
    var buttonObject = document.getElementById(button);
    if(buttonObject != null) {
        buttonObject.style.background = '#08C1FF';
        buttonObject.style.color = '#FFFFFF';
        buttonObject.style.fontWeight="bold";   
    }
}