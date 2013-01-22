<?php
    $db = connect_to_db();
    
    $sqli_product_lijst = $db->prepare("SELECT * FROM Producten");
    $sqli_product_lijst->bind_result($id,$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$datum_toegevoegd,$cover);
    $sqli_product_lijst->execute();
    
    
?>
<table id="Producten">
<tr><th>id</th><th>Titel</th><th>Cover</th><th>Platform</th><th>Genre</th><th>Prijs</th><th>Voorraad</th>

<?php
    $db2 = connect_to_db();
    $db3 = connect_to_db();
    while($sqli_product_lijst->fetch()){
        $sqli_platform_naam = $db2->prepare("SELECT naam FROM Platforms WHERE id=?");
        $sqli_platform_naam->bind_param('i',$id);
        $sqli_platform_naam->bind_result($platformnaam);
        
        $sqli_genre_naam = $db3->prepare("SELECT naam FROM Genres WHERE id=?");
        $sqli_genre_naam->bind_param('i',$id);
        $sqli_genre_naam->bind_result($genrenaam);
        
        $cover_var = '<img src="data:image/jpeg;base64,'.base64_encode($cover).'"/>';
        
        echo "<tr><td>$id</td><td>$titel</td><td>$cover_var</td><td>$platformnaam</td><td>$genrenaam</td><td>$prijs</td><td>$voorraad</td></tr>";
    }
?>