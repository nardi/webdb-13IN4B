<?php
    if (is_admin())
    {
        $db = connect_to_db();
        ?>
       
        
        <div class="centered-container">
        
            <!-- Het formulier voor het toevoegen van aanbiedingen. -->
            <form action="aanbieding-toevoegen-db.php" method="post">
                <h1><b>Aanbieding toevoegen</b></h1>
                <hr />
                <p><b>Aanbiedings-gegevens</b></p>
                
                <!-- Achterenvolgend wordt er gevraagd naar:
                     Het product, de actieprijs en van wanneer tot wanneer
                     de aanbieding duurt.
                     De producten wordne m.b.v. een query uit de database 
                     gehaald en weergeven in een dropdown menu. -->
                     
                <p class = "right_align">
                    Product: 
                    <select name="producten">
                    <?php
                        $productensql = $db->prepare("SELECT id, titel FROM Producten");
                        $productensql->bind_result($productid, $product);
                        $productensql->execute();
                        
                        while ($productensql->fetch()) {
                    ?>
                            <option value="<?php echo $productid; ?>"><?php echo $product; ?></option>
                    <?php
                        }
                        $productensql->free_result();
                    ?>
                    </select> <br />
                   
                    Aanbiedingsprijs: <input type="text" name="prijs" /><br />
                    Begin-datum: <input type="text" name="begin-datum" /><br />
                    Eind-datum: <input type="text" name="eind-datum" /><br />
                    
                    <!-- De ingevulde waardes worden gepost naar aanbieding-toevoegen-db.php gepost. -->
                    <input type="submit" value="Voeg aanbieding toe" />
           
                    <?php
                        $db->close();
                    ?>
                    
                    
                </p>
            </form>
        </div>
    <?php
    }
    
    else{
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
    }
?>