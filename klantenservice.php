<link rel="stylesheet" type="text/css" href="inloggen-wachtwoord-registratie.css">

<head>
<script>
function loadXMLDoc(link)
{
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",link,true);
xmlhttp.send();
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
	
		<form action=../">
		Waar gaat uw vraag over?
		<select id="myList" onchange="loadXMLDoc(this.options[this.selectedIndex].value,'_top')">
		<option value="">Kies een onderwerp...</option>
		<option value="klantenservice_factuur.php">Factuur</option>
		<option>Verzending</option>  
		<option>Artikel</option>
		<option>Klacht</option>
		</select>
		</form>
		
		</div>
		</div>
		
		</body>
		
		
		<?php
		}
		?>
		
		

		</html>

