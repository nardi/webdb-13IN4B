<?php
    if (is_admin())
    {
        $db = connect_to_db();

        $titel = $_POST['titel'];
        $beschrijving = $_POST['beschrijving'];
        $prijs = $_POST['prijs'];
        $release_date = $_POST['release_date'];
        $voorraad = $_POST['voorraad'];
        $platform = $_POST['platform'];
        $genre = $_POST['genre'];
           
        
        $sqli_producten = $db->prepare("INSERT INTO Producten (titel, beschrijving, prijs, release_date, voorraad, platform_id, genre_id)
        VALUES (?,?,?,?,?,?,?)");
        
        $sqli_producten->bind_param('sssssss', $titel, $beschrijving, $prijs, $release_date, $voorraad, $platform, $genre);

        if(!$sqli_producten->execute())
            throw new Exception($sqli_producten->error);

        $db->close();
        
        redirect_to("product-toevoegen-succesvol.html");
        
       
        $myFile = $_FILES['file']; // This will make an array out of the file information that was stored.
        $file = $myFile['tmp_name'];  //Converts the array into a new string containing the path name on the server where your file is.
        $myFileName = $_POST['MyFile']; //Retrieve file path and file name    
        $myfile_replace = str_replace('\\', '/', $myFileName);    //convert path for use with unix
        $myfile = basename($myfile_replace);    //extract file name from path
        $destination_file = "/".$myfile;  //where you want to throw the file on the webserver (relative to your login dir)
        // connection settings
        $ftp_server = "imghst.co";  //address of ftp server (leave out ftp://)
        $ftp_user_name = "infinity@imghst.co"; // Username
        $ftp_user_pass = "HlBgz19-]LT2";   // Password
        $conn_id = ftp_connect($ftp_server);        // set up basic connection
        // login with username and password, or give invalid user message
        $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("<h1>You do not have access to this ftp server!</h1>");
        $upload = ftp_put($conn_id, $destination_file, $file, FTP_BINARY);  // upload the file
        if (!$upload) {  // check upload status
            echo "<h2>FTP upload of $myFileName has failed!</h2> <br />";
        }
        ftp_close($conn_id); // close the FTP stream
    }
?>
