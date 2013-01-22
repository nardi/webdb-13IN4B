<link rel="stylesheet" type="text/css" href="main.css">

<?php
    $db = connect_to_db();
    
    $sqli_product_lijst = $db->prepare("SELECT Producten.id,titel,platform_id,genre_id,beschrijving,prijs,release_date,voorraad,datum_toegevoegd,cover,Platforms.naam,Genres.naam FROM Producten JOIN Producten ON platform_id=Platforms.id JOIN Genres ON genre_id=Genres.naam");
    $sqli_product_lijst->bind_result($id,$titel,$platform_id,$genre_id,$beschrijving,$prijs,$release_date,$voorraad,$datum_toegevoegd,$cover,$platformnaam,$genrenaam);
    $sqli_product_lijst->execute();
    
    
?>
<table id="Producten">
<tr><th>id</th><th>Titel</th><th>Cover</th><th>Platform</th><th>Genre</th><th>Prijs</th><th>Voorraad</th>

<?php
    $db2 = connect_to_db();
    $db3 = connect_to_db();
    while($sqli_product_lijst->fetch()){        
        $cover_var = '<img src="data:image/jpeg;base64,'.base64_encode($cover).'"/>';
        
        echo "<tr><td class=column>$id</td><td class=column>$titel</td><td class=column><div class='cover'>$cover_var</td></div><td class=column>$platformnaam</td><td class=column>$genrenaam</td><td class=column>$prijs</td><td class=column>$voorraad</td></tr>";
    }
?>