
function loadXMLDoc(dname)
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
xhttp.open("GET",dname,false);
xhttp.send();
document.getElementById("choice").innerHTML=xhttp.responseText;
}

