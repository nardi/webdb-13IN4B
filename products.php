<?php
    $db = connect_to_db();

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
    
    if (!$result = $db->query($query))
        throw new Exception("Er zijn foutieve parameters opgegeven.");
?>

<div id="products">

<div class="category">

<?php
    while ($row = $result->fetch_assoc())
    {
        $image = $row['cover'];
?>

<div class="product-thumb">
    <a href="product.php?id=<?php echo $row['id']; ?>"> <?php header("Content-type: image/jpeg"); echo $image;?></a>
    <p class="title"><a href="product.php?id=<?php echo $row['id']; ?>"><?php echo $row['titel']; ?></a></p>
    <p class="price"><a href="product.php?id=<?php echo $row['id']; ?>">&euro;<?php echo $row['prijs']; ?></a></p>
</div>
<?php
    }
?>

</div>

</div>

<?php
    $db->close();
?>