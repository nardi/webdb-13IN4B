<?php
    $db = connect_to_db();
	
    $query = "SELECT id, titel, prijs FROM Producten";
    
    if(isset($_GET['genres']) || isset($_GET['platforms']))
    {
        $query .= " WHERE";
    
        if (isset($_GET['genres']))
        {
            $query .= " (genre_id = ";
            $query .= implode(array_filter(explode(',', $db->escape_string($_GET['genres']))), " OR genre_id = ");
        }
        
        if (isset($_GET['platforms']))
        {
            if (isset($_GET['genres']))
                $query .= ") AND";
            $query .= " (platform_id = ";
            $query .= implode(array_filter(explode(',', $db->escape_string($_GET['platforms']))), " OR platform_id = ");
        }

        $query .= ")";
    }
    echo $query;
    
    $result = $db->query($query);
?>

<div id="products">

<div class="category">

<?php
    while ($row = $result->fetch_assoc())
    {
        $id = $row['id'];
        $titel = $row['titel'];
        $prijs = $row['prijs'];
?>

<div class="product-thumb">
    <a href="product.php?id=<?php echo $id; ?>">
    <img src="images/products/<?php echo $id; ?>.jpg" />
    <p class="title"><?php echo $titel; ?></p>
    <p class="price">&euro;<?php echo $prijs; ?></p>
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