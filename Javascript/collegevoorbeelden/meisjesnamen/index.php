<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AJAX example</title>
<script language="javascript" type="text/javascript">
var xmlhttp;

function GetXMLHTTPObject()
{
  var xmlhttp = null;

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }

  return xmlhttp;
}

function getNames(str)
{ 
  xmlhttp = GetXMLHTTPObject();
  if (xmlhttp == null){
    alert ("Your browser does not support HTTP requests");
    return;
  }
  
  var url="queryResult.php";
  str = str.replace(/\n/g, " ");
  url = url + "?q=" + str;
  url = url + "&sid=" + Math.random();

  xmlhttp.onreadystatechange = stateChanged;
  xmlhttp.open("GET", url, true);
  xmlhttp.send(null);
}


function stateChanged(str)
{
  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) { 
    document.getElementById("queryResult").innerHTML = xmlhttp.responseText;
  }
}
</script>
</head>
<body>
<h1>Meisjesnamen</h1>
</form>
  Naam:
  <input type="text" name="naam" onkeyup="getNames(this.value)" />
</form>
<p>
<div id="queryResult" >
<b>Namen die matchen worden hier getoond</b>
</div>
</p>
</body>
</html>
