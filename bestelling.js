function laadBevestiging()
{
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/annuleringsbevestiging.html');
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4)
            document.getElementById('annuleringsbevestiging').innerHTML = xhr.responseText;
    };
    xhr.send();
}