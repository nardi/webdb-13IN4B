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
        if(!$sql->execute())
            throw new Exception($sql->error);

        $db->close();
        ?>
        
        De aanbieding is toegevoegd.
        
        <script type="text/JavaScript">
			setTimeout("location.href = 'aanbiedingen.php';",2000);
		</script>    
     <?php
     }
     
     else{
        throw new Exception("U heeft niet de juiste privileges om deze pagina te zien.");
    }
?>