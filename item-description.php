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
    /*Onderstaande verkrijgt dynamisch de informatie over een product op basis van de meegegeven id.*/
    $id=$_GET["id"];
    $db = connect_to_db();
    $sqli_product = $db->prepare("SELECT titel,platform_id,genre_id,beschrijving, prijs,
    release_date, voorraad, datum_toegevoegd FROM Producten WHERE id=?");
    $sqli_product->bind_param('i',$id);
    $sqli_product->bind_result($titel,$platform,$genre,$beschrijving,$prijs,$release,$voorraad,$toegevoegd);
    if(!$sqli_product->execute())
        throw new Exception($sqli_product->error);
    if(!$sqli_product->fetch())
        redirect_to("error.php?msg=Oeps, dit product bestaat niet.");
    
    //Free result is nodig om de volgende query te laten lukken.
    $sqli_product->free_result();
    
    /*Hieronder wordt de mening van de reviewers weergegeven. Als de gebruiker id 
    NULL is, dan is de review geschreven door een professionele reviewer en bevat hij 
    alleen quotes.*/
    $sqli_quotes = $db->prepare("SELECT tekst,reviewer FROM Reviews WHERE product_id=? AND gebruiker_id=NULL");
    
    $sqli_quotes->bind_param('i',$id);
    $sqli_quotes->bind_result($reviews, $reviewer);
    $quotes="";
    if(!$sqli_quotes->execute())
        throw new Exception($sqli_quotes->error);
        
    while($sqli_quotes->fetch()){
        $quotes.= $reviews."--".$reviewer."<br /><hr />";
    }
    //Free  results for de volgende query.
    $sqli_quotes->free_result();
    
    /*Haal systeem vereiste op uit de database.*/
    $sqli_sysreq = $db->prepare("SELECT cpu,gpu,ram,os FROM System_Requirements WHERE product_id=?");
    $sqli_sysreq->bind_param('i',$id);
    $sqli_sysreq->bind_result($cpu,$gpu,$ram,$os);
    
    $sqli_sysreq->free_result();
    
    $db->close();
    
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
        echo '<img src="images/products/"' .$id. '".jpg" alt="Game cover" />';
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
<th colspan="2"> Systeem Vereiste </th>
</tr>
<tr>
<td>CPU</td><td> <?php $cpu ?></td>
</tr>
<tr>
<td>RAM</td><td> <?php $ram ?></td>
</tr>
<tr>
<td>GPU</td> <td><?php $gpu ?></td>
</tr>
<tr>
<td>OS</td> <td><?php $os ?></td>
</tr>
</table>
</div>

</div>
</body>

</html>
