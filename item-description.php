<link rel="stylesheet" type="text/css" href="item-description.css">

<body>
<?php 
    /*Onderstaande verkrijgt dynamisch de informatie over een product op basis van de meegegeven id.*/
    $id=$_GET["id"];
    $db = connect_to_db();
    $sqli_product = $db->prepare("SELECT titel,platform_id,genre_id,beschrijving, prijs,
    release_date, voorraad, datum_toegevoegd, cover FROM Producten WHERE id=?");
    $sqli_product->bind_param('i',$id);
    $sqli_product->bind_result($titel,$platform,$genre,$beschrijving,$prijs,$release,$voorraad,$toegevoegd, $cover);
    if(!$sqli_product->execute())
        throw new Exception($sqli_product->error);
    if(!$sqli_product->fetch())
        redirect_to("error.php?msg=Oeps, dit product bestaat niet.");
    
    //Free result is nodig om de volgende query te laten lukken.
    $sqli_product->free_result();
    
    /*Hieronder wordt de mening van de reviewers weergegeven. Als de gebruiker id 
    NULL is, dan is de review geschreven door een professionele reviewer en bevat hij 
    alleen quotes.*/
    $sqli_quotes = $db->prepare("SELECT tekst,reviewer FROM Reviews WHERE product_id=? AND gebruiker_id is NULL");
    
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
    if(!$sqli_sysreq->execute())
        throw new Exception($sqli_sysreq->error);
    $sqli_sysreq->fetch();
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
<div id="ItemCoverContainer">
    <div id="ItemCover">
    <h4>Game cover</h4>
        <?php
            echo '<img src="data:image/jpeg;base64,'.base64_encode($cover).'" />';
        ?>
    </div>
    <div id="ItemWWToevoegen">
        <form name="ActuallyAButton" id="AddToCartButton" action="winkelwagen.php" method="post">
            <input type="hidden" name="add" value="<?php echo $_GET['id'] ?>">
            <input type="submit" value="" name="submitButton" id="AddSubmitButton">
        </form>
    </div>
    <?php
        $id = $_GET['id'];
        if(is_admin()){echo "
            <div id='ItemVerwijderen'>
                <form name='ActuallyAButton' id='DeleteItem' action='product-verwijderen.php' method='post'>
                    <input type='hidden' name='delete' value='$id'>
                    <input type='submit' value='' name='submitButton' id='DeleteSubmitButton'>
                </form>
            </div>";
        }
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
<td>CPU</td><td> <?php echo $cpu ?></td>
</tr>
<tr>
<td>RAM</td><td> <?php echo $ram ?></td>
</tr>
<tr>
<td>GPU</td> <td><?php echo $gpu ?></td>
</tr>
<tr>
<td>OS</td> <td><?php echo $os ?></td>
</tr>
</table>
</div>

</div>
</body>

</html>
