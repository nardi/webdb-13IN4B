<div class="centered-container">
    <div id="filters">
        <form method="get" action="products.php">
            Platform:
            <div class="platform">
                <select name="platforms">

                <?php
                $db = connect_to_db();
                $platformsql = $db->prepare("SELECT id, naam FROM Platforms");
                $platformsql->execute();
                $platformsql->bind_result($platformid, $platform);
                
                echo "<option value='0'>--- Geen ---</option>";
                
                while ($platformsql->fetch()) {
                    ?>
                    <option value="<?php echo $platformid; ?>"><?php echo $platform; ?></option>
                    <?php
                }
                
                $platformsql->free_result();
                ?>
                
                </select>
            </div>          
            
            Genre:
            <div class="genre">

                <select name="genres">
            
                <?php
                $genresql = $db->prepare("SELECT id, naam FROM Genres");
                $genresql->execute();
                $genresql->bind_result($genreid, $genre);

                echo "<option value='0'>--- Geen ---</option>";
            
                while ($genresql->fetch()) {
                    ?>
                    <option value="<?php echo $genreid; ?>"><?php echo $genre; ?></option>
                    <?php
                }
            
                $genresql->free_result();
                ?>
                </select>
            </div>      
            <br />
        
            <input type="submit" value="Pas filters toe">
        </form>
    </div>
    <hr>

    <?php
        function check_array(&$var, $id, $db)
        {
            $var = $db->escape_string($var);
            $var = intval($var);
        }
        
        $query = "SELECT COUNT(*), Producten.id, titel, cover, Producten.prijs, Aanbiedingen.prijs FROM Producten LEFT JOIN Aanbiedingen ON product_id = Producten.id WHERE verwijderd != 1";
        
        if(isset($_GET['genres']) && $_GET['genres'] != 0) 
        {
            $genres_valid = true;
        }
        else 
        {
            $genres_valid = false;
        }
        
        if(isset($_GET['platforms']) && $_GET['platforms'] != 0) 
        {
            $platforms_valid = true;
        }
        else 
        {
            $platforms_valid = false;
        }
        
        
        if($genres_valid || $platforms_valid)
        {
            $query .= " AND";
        
            if ($genres_valid)
            {
                $query .= " (genre_id = ";
                $genres = explode(',', $_GET['genres']);
                array_walk($genres, 'check_array', $db);
                $query .= implode(" OR genre_id = ", array_filter($genres));
            }
            
            if ($platforms_valid)
            {
                if ($genres_valid)
                    $query .= ") AND";
                $query .= " (platform_id = ";
                $platforms = explode(',', $_GET['platforms']);
                array_walk($platforms, 'check_array', $db);
                $query .= implode(" OR platform_id = ", array_filter($platforms));
            }

            $query .= ")";
        }
        
        if (isset($_GET['search']))
        {
            $search = '%' . $db->escape_string($_GET['search']) . '%';
            $query .= " AND titel LIKE ?";
        }
        
        $productsperpage = 20;
        if (isset($_GET['page']))
        {
            $page = intval($db->escape_string($_GET['page']));
            if ($page < 1)
                $page = 1;
        }
        else
        {
            $page = 1;
        }
        $query .= " LIMIT " . ($page - 1) * $productsperpage . ", " . $productsperpage;

        $sqli = $db->prepare($query);
        if (isset($search))
            $sqli->bind_param('s', $search);
        $sqli->bind_result($numproducts, $id, $titel, $cover, $prijs, $aanbiedingsprijs);
        if (!$sqli->execute())
                throw new Exception("Er zijn foutieve parameters opgegeven.");
    ?>


    <div class="category">
        <div class="product-row">
    <?php
        $count = 1;
        while ($sqli->fetch())
        {
            $cover = is_valid_cover($cover);
            if (!isset($aanbiedingsprijs))
                $aanbiedingsprijs = null;
            product_thumb($id, $cover, $titel, $prijs, $aanbiedingsprijs);
            
            if ($count % 4 == 0)
                echo '</div><div class="product-row">';
            
            $count++;
        }
    ?>
        </div>
    <?php
        // Deze functie haalt de huidige page-waarde(n) uit de url
        function clean_url($url, $toremove)
        {
            while (($pagepos = strpos($url, $toremove)) !== FALSE)
            {
                $pageend = strpos($url, '&', $pagepos + strlen($toremove));
                if ($pageend === FALSE)
                    $url = substr($url, 0, $pagepos);
                else
                    $url = substr($url, 0, $pagepos) . substr($url, $pageend);
            }
            return $url;
        }
    
        $url = $_SERVER['REQUEST_URI'];
        $url = clean_url($url, '&page=');
        $url = clean_url($url, 'page=');        
        if ($_SERVER['QUERY_STRING'] == '')
            $url .= '?';
    
        /* $count = $db->prepare("SELECT  FROM Producten");
        $count->execute();
        $count->bind_result($numproducts);
        $count->fetch(); */
    
        $prevpage = $page - 1;
        $has_prevpage = $page > 1;
        $nextpage = $page + 1;
        $has_nextpage = $numproducts > $page * $productsperpage + 1;
        
        echo '<p>';
        if ($has_prevpage)
            echo '<a href="'.$url.'&page='.$prevpage.'">< Vorige</a> ';
        if ($has_prevpage || $has_nextpage)
            echo '|';
        if ($has_nextpage)
            echo ' <a href="'.$url.'&page='.$nextpage.'">Volgende ></a>';
        echo '</p>';
        
       // $count->free_result();
    ?>
    </div>

</div>

<?php
    $db->close();
?>