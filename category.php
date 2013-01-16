<?php
    require 'main.php';

    $db = connect_to_db();
	
    if (!isset($_GET['genre']))
    {
         echo "Geef een categorie op.";
    }
    else
    {
        $genre_id = $_GET['genre'];
        
        $sql = $db->query("SELECT naam FROM Genres WHERE id = ?");
        $sql->bind_param("i", $genre_id);
        if(!$sql->execute())
            throw new Exception($sql->error);
        $sql->bind_result($genre_naam);
        if (!$sql->fetch())
        {
            echo "Deze categorie bestaat niet.";
            exit();
        }
        $genre = "$genre_naam";
        $sql->free_result();
        
        $sql = $db->prepare("SELECT id, titel, prijs FROM Producten WHERE genre.id = $genre_id");
        $sql->bind_param("i", $genre_id);
        if(!$sql->execute())
            throw new Exception($sql->error);
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
    <p class="title"><?php echo $titel; ?></p>
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