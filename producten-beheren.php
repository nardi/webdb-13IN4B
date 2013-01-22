<link rel="stylesheet" type="text/css" href="main.css">

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
        $sqli_platform_naam->bind_param('i',$platform_id);
        $sqli_platform_naam->bind_result($platformnaam);
        echo "$platformnaam . FAILED! . $platform_id";
        
        if(!$sqli_platform_naam->execute())
            $db2->error;
        
        
        $sqli_genre_naam = $db3->prepare("SELECT naam FROM Genres WHERE id=?");
        $sqli_genre_naam->bind_param('i',$genre_id);
        $sqli_genre_naam->bind_result($genrenaam);
        $sqli_genre_naam->execute();
        
        $cover_var = '<img src="data:image/jpeg;base64,'.base64_encode($cover).'"/>';
        
        echo "<tr><td class=column>$id</td><td class=column>$titel</td><td class=column><div class='cover'>$cover_var</td></div><td class=column>$platformnaam</td><td class=column>$genrenaam</td><td class=column>$prijs</td><td class=column>$voorraad</td></tr>";
    }
?>