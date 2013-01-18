<?php
    if (is_admin())
    {
        function assertValidUpload($code)
    {
        if ($code == UPLOAD_ERR_OK) {
            return;
        }
 
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $msg = 'Image is too large';
                break;
 
            case UPLOAD_ERR_PARTIAL:
                $msg = 'Image was only partially uploaded';
                break;
 
            case UPLOAD_ERR_NO_FILE:
                $msg = 'No image was uploaded';
                break;
 
            case UPLOAD_ERR_NO_TMP_DIR:
                $msg = 'Upload folder not found';
                break;
 
            case UPLOAD_ERR_CANT_WRITE:
                $msg = 'Unable to write uploaded file';
                break;
 
            case UPLOAD_ERR_EXTENSION:
                $msg = 'Upload failed due to extension';
                break;
 
            default:
                $msg = 'Unknown error';
        }
 
        throw new Exception($msg);
    }
 
    $errors = array();
 
    try {
        if (!array_key_exists('image', $_FILES)) {
            throw new Exception('Image not found in uploaded data');
        }
 
        $image = $_FILES['image'];
 
        // ensure the file was successfully uploaded
        assertValidUpload($image['error']);
 
        if (!is_uploaded_file($image['tmp_name'])) {
            throw new Exception('File is not an uploaded file');
        }
 
        $info = getImageSize($image['tmp_name']);
 
        if (!$info) {
            throw new Exception('File is not an image');
        }
    }
    catch (Exception $ex) {
        $errors[] = $ex->getMessage();
    }
 
    if (count($errors) == 0) {
        // no errors, so insert the image
    
    
    
    
    
    
    
        $db = connect_to_db();
        
        $titel = $_POST['titel'];
        $beschrijving = $_POST['beschrijving'];
        $prijs = $_POST['prijs'];
        $release_date = $_POST['release_date'];
        $voorraad = $_POST['voorraad'];
        $platform = $_POST['platform'];
        $genre = $_POST['genre'];
        $image = $_FILES['image'];
        $data = file_get_contents($image['tmp_name']);
        
           
        
        $sqli_producten = $db->prepare("INSERT INTO Producten (titel, beschrijving, prijs, release_date, voorraad, platform_id, genre_id, cover)
        VALUES (?,?,?,?,?,?,?,?)");
        
        $sqli_producten->bind_param('ssssssss', $titel, $beschrijving, $prijs, $release_date, $voorraad, $platform, $genre, $data);

            if(!$sqli_producten->execute())
                throw new Exception($sqli_producten->error);

        $db->close();
    
    }
    
    redirect_to("product-toevoegen-succesvol.html");
    }
?>
