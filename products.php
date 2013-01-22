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

<div id="products">

<div class="category">

<?php
    while ($sqli->fetch())
    {
     
?>

<div class="product-thumb">
    <a href="item-description.php?id=<?php echo $id; ?>"> <?php echo '<img src="' . $imagedir . $cover . '"/>'; ?></a>
    <p class="title"><a href="item-description.php?id=<?php echo $id; ?>"><?php echo $titel; ?></a></p>
    <p class="price"><a href="item-description.php?id=<?php echo $id; ?>">&euro;<?php echo $prijs; ?></a></p>
</div>
<?php
    }
?>


<!-- Testcode!! -->
<img src="../uploads/test.jpg"> <br />
<?php echo "$_SERVER['SCRIPT_FILENAME']" ?>

</div>

</div>

<?php
    $db->close();
?>