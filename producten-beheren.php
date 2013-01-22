<?php
    $db = connect_to_db();
    
    $sqli_product_lijst = $db->prepare("SELECT * FROM Producten");
    $sqli_product_lijst->bind_result($id,$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$datum_toegevoegd,$cover);
    $sqli_product_lijst->execute();
    $sqli_product_lijst->free_result();
    
?>
<table id="Producten">
<tr><th>id</th><th>Titel</th><th>Cover</th><th>Platform</th><th>Genre</th><th>Prijs</th><th>Voorraad</th>
<?php
    while($sqli_product_lijst->fetch()){
        $sqli_platform_naam = $db->prepare("SELECT naam FROM Platforms WHERE id=?");
        $sqli_platform_naam->bind_param('i',$id);
        $sqli_platform_naam->bind_result($platformnaam);
        
        $sqli_genre_naam = $db->prepare("SELECT naam FROM Genre WHERE id=?");
        $sqli_genre_naam->bind_param('i',$id);
        $sqli_genre_naam->bind_result($genrenaam);
        
        echo "<tr><td>$id</td><td>$titel</td><td>$cover</td><td>$platformnaam</td><td>$genrenaam</td><td>$prijs</td><td>$voorraad</td></tr>";
    }
?>