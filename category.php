<?php
    require 'main.php';

    $db = connect_to_db();
	
    if (!isset($_GET['genre']))
    {
         echo "Geef een categorie op";
    }
    else
    {
        $genre = $_GET['genre'];
        
        $sql = $db->prepare("SELECT id, titel, prijs FROM Producten WHERE genre = ?");
        $sql->bind_param("s", $genre);
        $sql->execute();
        $sql->bind_result($id, $titel, $prijs);

        if (!$sql->fetch())
        {
            echo "Er zijn geen producten in deze categorie.";
        }
        else
        {
?>

<div id="category">

<div class="category">

<h1><?php echo $genre; ?></h1>
<?php
        do {
?>

<div class="product-thumb">
    <a href="product.php?id=<?php echo $id; ?>">
    <img src="images/products/<?php echo $id; ?>.jpg" />
    <p class="title"><?php echo $genre; ?></p>
    <p class="price">&euro;<?php echo $prijs; ?></p>
    </a>
</div>
<?php
        } while ($sql->fetch());
?>

</div>

</div>

<?php    
        }
        
        $sql->free_result();
        $db->close();
    }
?>