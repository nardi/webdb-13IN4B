
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
}
}

