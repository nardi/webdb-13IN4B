<!DOCTYPE html>

<?php
setcookie("user", "sis_user", time()+3600);
?>

<html>
<head> 
  <title>Over ons</title>
  <link rel="stylesheet" type="text/css" href="overons.css">

  <script>

<?php
if (isset($_COOKIE["user"]))
    window.onload = alert("Deze website maakt gebruik van functionele cookies, \
    bij het gebruik van de website gaat u hiermee akkoord.") ;
else
  echo "";
?>

  </script>

  <noscript>
    <div class = red_line>
      <p class = center> <img src="/images/labels/error-label.png" alt="error-label" width="35" height="35"> Deze website wordt alleen juist weergegeven met javascript. </p>
    </div>
  </noscript>
</head>

<body> 




  <div>
    <h1 class="center"> Wie zijn wij? </h1>

      <p>Wij zijn een groepje van 5 informatica studenten die studeren aan de <a href="http://www.uva.nl">Universiteit van Amsterdam</a>.
        Wij hebben als opdracht in onze projectmaand gekozen een website voor een webshop te maken.
        Wij hebben ervoor gekozen om een webshop met games te maken.</p>



<br/>
<br/>

<img class="displayed" src="/images/science-park.jpg" alt="science-park" width="468" height="264">


<br/>
<br/>
<div>
<h1 class="center"> <a id="contact">Contactgegevens</a> </h1>

<p> Mocht u vragen hebben over onze service of vragen in het algemeen dat kunt u onderstaande gegevens gebruiken om contact met ons op te nemen.

<br/>
<br/>

<div class="center">

U kunt ons een bericht sturen via <a href="http://www.superinternetshop.nl/contactformulier.php">dit contactformulier</a> 

<br/>

<h3>Telefoonnummer:</h3> <pre>(020) 525 2695</pre>

<br/>

<h3>Adres:</h3> <pre>Super Internet Shop<br/>
Science Park 904<br/>
1098 XH  AMSTERDAM</pre>
</div>


</div>
</body>
</html>


