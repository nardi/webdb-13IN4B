<?php
    if (is_admin())
    {
        $db = connect_to_db();
        $productid = $_POST['producten'];
        $prijs = $_POST['prijs'];
        $startdatum = $_POST['begin-datum'];
        $einddatum = $_POST['eind-datum'];
       
        $sql = $db->prepare("INSERT INTO Aanbiedingen (product_id, prijs, start_datum, eind_datum)
        VALUES (?,?,?,?)");
        $sql->bind_param('isss', $productid, $prijs, $startdatum, $einddatum);
        if(!$sqli_producten->execute())
            throw new Exception($sql->error);

        $db->close();
        
        redirect_to("aanbieding-toevoegen.php");
        ?>
        
        <script type="text/javascript">
            alert("Aanbieding succesvol toegevoegd");
        </script>    
     <?php
     }
?>