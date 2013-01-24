<?php
    if (is_admin())
    {
        $db = connect_to_db();
        ?>
       
        
        <div class="centered-container">
            <form action="aanbieding-toevoegen-db.php" method="post">
                <div align="right"> 
                    <h1><center><b>Aanbieding toevoegen</b></center></h1>
                    <hr width="100%">
                    <center><b>Aanbiedings-gegevens</b></center>
                    <br />
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
                        $db->close();
                    ?>
                    </select> <br />
                    
                    Aanbiedingsprijs: <input type="text" name="prijs"><br />
                    Begin-datum: <input type="text" name="begin-datum"><br />
                    Eind-datum: <input type="text" name="eind-datum"><br />
                    
                    <input type="submit" value="Voeg aanbieding toe">
           
                    
                    
                    
                </div>
            </form>
        </div>
    <?php
    }
?>