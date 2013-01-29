<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<head>
<script>
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

</script>
</head>

<body>

<?php
	if ((!isset($_SESSION['logged-in']))) {
		?>
		<pre>
		U bent niet ingelogd!
		</pre>
		<?php
	} else {
		?>
		<div class="account-wachtwoord-veranderen">
		<div align="right"> 
		<h1><center><b>Klantenservice</b></center></h1>
		<hr width="100%">
		<center><b>Vragen over uw factuur</b></center>
		<br />
	
		<form>
		Waar gaat uw vraag over?
		<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value)">
		<option value="">Kies een onderwerp...</option>
		<option value="backend/klantenservice_factuur.php">Factuur</option>
		<option value="klantenservice_verzending.xml">Verzending</option>  
		<option>Artikel</option>
		<option>Klacht</option>
		</select>
		</form>
		
		<div id="choice">
		
		
		</div>
		</div>
		
		</body>
		
		
		<?php
		}
		?>
		
		

		</html>

