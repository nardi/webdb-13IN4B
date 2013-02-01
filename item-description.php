<?php 
    require 'product-verwijderen-conf.php';
    /*Onderstaande verkrijgt dynamisch de informatie over een product op basis van de meegegeven id.*/
    $id=$_GET["id"];
    $db = connect_to_db();
    $sqli_product = $db->prepare("SELECT titel,platform_id,genre_id,beschrijving,
    release_date, voorraad, datum_toegevoegd, cover FROM Producten WHERE id=?");
    $sqli_product->bind_param('i',$id);
    $sqli_product->bind_result($titel,$platform,$genre,$beschrijving,$release,$voorraad,$toegevoegd, $cover);
    if(!$sqli_product->execute())
        throw new Exception($sqli_product->error);
    if(!$sqli_product->fetch())
        throw new Exception("Oeps, dit product bestaat niet.");
    
    //Free result is nodig om de volgende query te laten lukken.
    $sqli_product->free_result();
    $prijs = actuele_prijs($id);
    
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
<div id="ItemName" class="header">
<h3>
    <?php
       echo htmlspecialchars($titel);
    ?>
</h3>
</div>
<div id="variablewidth">
    <div id="ItemCoverContainer">
    
        <div id="ItemCover">
        <div class="header">
        <h4>Game cover</h4>
        </div>
            <?php
                echo '<img src="'. is_valid_cover($cover) .'" alt="Cover" />';
            ?>
        </div>
        <form id="AddToCartButton" action="winkelwagen.php" method="post">
            <div id="ItemWWToevoegen">
                <input type="hidden" name="add" value="<?php echo $_GET['id'] ?>" />
                <input type="submit" value="" name="submitButton" id="AddSubmitButton" />
            </div>
        </form>
        <?php
            $id = $_GET['id'];
            if(is_admin()){echo "
                <form id='DeleteItem' action='product_verwijderen_conf_func($id,$titel)' method='post'>
                    <div id='ItemVerwijderen'>
                        <input type='hidden' name='delete' value='$id' />
                        <input type='submit' value='' name='submitButton' id='DeleteSubmitButton' title='Product verwijderen'/>
                    </div>
                </form>";
            }
        ?>
    </div>
    
    <div class="buffer">
    </div>


    <div id="game-description-en-prijs">
    <div id="ItemDescription">
    <div class="header">
    <h4>Game Description</h4>
    </div>
    <?php
            echo htmlspecialchars($beschrijving);
        ?>
    </div>

    <div id="Prijs">
    <hr />
        <?php
            echo "&euro;".prijs_opmaak($prijs);
        ?>
    </div>
    </div>
    
    <div class="buffer">
    </div>
    
    <?php
        if($quotes != ""){
        echo "
            <div id='Quotes'>
            <div class='header'>
            <h4>Wat vonden reviewers van dit spel?</h4>
            </div>
                $quotes;
            </div>
            <div class='buffer'>
            </div>";
        }

        if($platform == '5' && $cpu != NULL){
            echo "
            <div id='SystemRequirements'>
            <table class='SystemRequirementsTable'>
            <tr>
            <th colspan='2'> Systeem Vereiste </th>
            </tr>
            <tr>
            <td>CPU</td><td>$cpu</td>
            </tr>
            <tr>
            <td>RAM</td><td>$ram</td>
            </tr>
            <tr>
            <td>GPU</td> <td>$gpu</td>
            </tr>
            <tr>
            <td>OS</td> <td>$os</td>
            </tr>
            </table>
            </div>";
        }
    ?>
    </div>
</div>
