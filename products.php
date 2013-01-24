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

        while ($genresql->fetch()) {
?>
						  <option value="<?php echo $genreid; ?>"><?php echo $genre; ?></option>
<?php
        }
        
        $genresql->free_result();
        
?>
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
    
    $query = "SELECT id, titel, prijs, cover FROM Producten";
    
    if(isset($_GET['genres']) || isset($_GET['platforms']))
    {
        $query .= " WHERE";
    
        if (isset($_GET['genres']))
        {
            $query .= " (genre_id = ";
            $genres = explode(',', $_GET['genres']);
            array_walk($genres, 'check_array', $db);
            $query .= implode(" OR genre_id = ", array_filter($genres));
        }
        
        if (isset($_GET['platforms']))
        {
            if (isset($_GET['genres']))
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
        $search = $db->escape_string($_GET['search']);
        if (isset($_GET['genres']) || isset($_GET['platforms']))
            $query .= " AND";
        else
            $query .= " WHERE";
        $query .= " MATCH (titel, beschrijving) AGAINST (? IN BOOLEAN MODE)";
    }
    
    $sqli = $db->prepare($query);
    if (isset($search))
        $sqli->bind_param('s', $search);
    $sqli->bind_result($id, $titel, $prijs, $cover);
    if (!$sqli->execute())
            throw new Exception("Er zijn foutieve parameters opgegeven.");
?>


<div class="category">

<?php
    while ($sqli->fetch())
    {
    
        $cover = is_valid_cover($cover);
?>

<div class="product-thumb">
    <a href="item-description.php?id=<?php echo $id; ?>"> <?php echo '<img src="' . $cover . '"/>'; ?></a>
    <p class="title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></p>
    <p class="price"><a href="item-description.php?id=<?php echo $id; ?>">&euro;<?php echo $prijs; ?></a></p>
</div>
<?php
    }
 ?>
 
</div>

</div>

<?php
    $db->close();
?>