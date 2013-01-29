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
        
        $query = "SELECT id, titel, cover FROM Producten WHERE verwijderd != 1";
        
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
        
        $sqli = $db->prepare($query);
        if (isset($search))
            $sqli->bind_param('s', $search);
        $sqli->bind_result($id, $titel, $cover);
        if (!$sqli->execute())
                throw new Exception("Er zijn foutieve parameters opgegeven.");
    ?>


    <div class="category">
        <div class="product-row">
    <?php
        $count = 1;
        while ($sqli->fetch())
        {
            $prijs = actuele_prijs($id);
            $cover = is_valid_cover($cover);
            product_thumb($id, $cover, $titel, $prijs);
            
            if ($count % 4 == 0)
                echo '</div><div class="product-row">';
            
            $count++;
        }
     ?>
        </div>
    </div>

</div>

<?php
    $db->close();
?>