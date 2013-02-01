//Deze functie is tot stand gekomen door gebruik te maken en het aanpassen van de gegeven functie op w3schools.com/dom/dom_loadxmldoc.asp
//Deze functie krijgt als argument de url en de id van de div waarin de opgevraagde contect geladen moet worden.
//Deze funcite opent een nieuw xml of php bestand dmv een xmlhttprequest. Deze functie wordt alleen gebruikt voor de interactieve 
//Klantenservice die werkt op javascript. 

function loadXMLDoc(url, element_id)
{
if (url !="")
{
var xhttp;
if (window.XMLHttpRequest)
  {
  xhttp=new XMLHttpRequest();
  }
else
  {
  xhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xhttp.open("GET",url,false);
xhttp.send();
document.getElementById(element_id).innerHTML=xhttp.responseText;
} else {
document.getElementById(element_id).innerHTML="";
}
}

