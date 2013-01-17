<?php
    $db = connect_to_db();

    function check_array(&$array, $id, $db)
    {
        echo $array[$id];
        $array[$id] = $db->escape_string($array[$id]);
        echo $array[$id];
        $array[$id] = '';
        echo print_r($array, TRUE);
    }
    
    $query = "SELECT id, titel, prijs FROM Producten";
    
    if(isset($_GET['genres']) || isset($_GET['platforms']))
    {
        $query .= " WHERE";
    
        if (isset($_GET['genres']))
        {
            $query .= " (genre_id = ";
            $genres = explode(',', $_GET['genres']);
            echo print_r($genres, TRUE);
            array_walk($genres, 'check_array', $db);
            echo print_r($genres, TRUE);
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
    echo $query;
    
    if (!$result = $db->query($query))
        throw new Exception("Er zijn foutieve parameters opgegeven.");
?>

<div id="products">

<div class="category">

<?php
    while ($row = $result->fetch_assoc())
    {
?>

<div class="product-thumb">
    <a href="product.php?id=<?php echo $row['id']; ?>">
    <img src="images/products/<?php echo $row['id']; ?>.jpg" />
    <p class="title"><?php echo $row['titel']; ?></p>
    <p class="price">&euro;<?php echo $row['prijs']; ?></p>
    </a>
</div>
<?php
    }
?>

</div>

</div>

<?php
    $db->close();
?>