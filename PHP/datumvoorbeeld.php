<html>
<head>
	<title>Voorbeeldje: werken met datums</title>
</head>
<body>

<?php
//dit script laat zien hoe je een week te pakken krijgt
//met wat meer moeite lukt het ook voor 'n maand

//twee nuttige formats voor dezelfde datum:
//mktime levert een timestamp; getdate zet timestamp om in array
$now = mktime();
$datearr= getdate($now);

//nu begin en eind van de week pakken:
//rekenen doe je met de timestamps (in seconden)
$wkday = $datearr["wday"];
$time1 = $now - $wkday * 24*60*60;
$time2 = $time1 + 6*24*60*60;

//geschikt maken voor mysql (mysql wil een string)
$mysqldate1=date("Y-m-d", $time1);
$mysqldate2=date("Y-m-d", $time2);

//testen
print "<p>Datum 1: $mysqldate1 </p>";
print "<p>Datum 2: $mysqldate2 </p>";
?>

