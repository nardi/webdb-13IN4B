/* Deze code maakt gebruik van de voorbeeld code gegeven in het college.
 * Met deze code wordt een een XMLHTTPRequest gegenereerd en naar adplus-query.php
 * gestuurd, wleke zich bevindt in de backend map. Dit PHP bestand kijkt naar de invoer
 * van de gebruiker en zoekt aan de hand hiervan naar bijpassende gebruikers.
 */

function GetXMLHTTPObject()
{
  var xmlhttp = new XMLHttpRequest();
  return xmlhttp;
}

function getNames(str)
{
  xmlhttp = GetXMLHTTPObject();
  if (xmlhttp == null){
    alert ("Your browser does not support HTTP requests");
    return;
  }

  var url="backend/adplus-query.php";
  str = str.replace(/\n/g, " ");
  url = url + "?email=" + str;
  url = url + "&sid=" + Math.random();

  xmlhttp.onreadystatechange = stateChanged;
  xmlhttp.open("GET", url, true);
  xmlhttp.send(null);
}

function stateChanged(str)
{
  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    document.getElementById("userlist").innerHTML = xmlhttp.responseText;
  }
}



