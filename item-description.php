<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>Item Specificaties</title>
   <link rel="stylesheet" type="text/css" href="item-description.css">
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<?php 
    require 'main.php';
    $id=$_GET["id"];
    $db = connect_to_db();
    $sqli_product = $db->prepare("SELECT titel,platform_id,genre_id,beschrijving, prijs,
    release_date, voorraad, datum_toegevoegd FROM Producten WHERE id=?");
    $sqli_product->bind_param('s',$id);
    $sqli_product->bind_result($titel,$platform,$genre,$beschrijving.$prijs,$release,$voorraad,$toegevoegd);
    if(!$sqli_product->execute())
        echo "Fail";
        //throw new Exception($sqli_product->error);
        
    $sqli_quotes = $db->prepare("SELECT tekst FROM Reviews WHERE id=?");
    $sqli_quotes->bind_param('s',$id);
    $sqli_quotes->bind_result($reviews);
    $quotes="";
    while($sqli_quotes->fetch()){
        $quotes.= "<br /><hr />".$reviews;
    }
    ?>
<div class="ItemDescriptionContainer">
<div id="ItemName">
<h3>
    <?php
       echo $titel;
    ?>
</h3>
</div>

<div id="ItemCover">
<h4>Game cover</h4>
    <?php
        echo '<img src="images/products/" .$id. ".jpg" alt="Game cover" />';
    ?>
</div>




<div id="game-description-en-prijs">
<div id="ItemDescription">
<h4>Game Description</h4>
<?php
        echo $beschrijving;
    ?>
</div>

<div id="Prijs">
<hr />
    <?php
        echo "&euro;".$prijs;
    ?>
</div>
</div>

<div id="Quotes">
<h4>Wat vonden reviewers van dit spel?</h4>
    <?php
        echo $quotes;
    ?>
</div>

<div id="SystemRequirements">
<table class="SystemRequirementsTable">
<tr>
<th colspan="2"> Minimum System </th>
</tr>
<tr>
<td>CPU</td><td> Toad-core</td>
</tr>
<tr>
<td>RAM</td><td> 3 GigaFrogs </td>
</tr>
<tr>
<td>GPU</td> <td>GToadX 550</td>
</tr>
</table>
</div>

</div>
</body>

</html>
