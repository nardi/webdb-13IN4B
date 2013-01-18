<?php    
$myFile = $_FILES['file']; // This will make an array out of the file information that was stored.
    $file = $myFile['tmp_name'];  //Converts the array into a new string containing the path name on the server where your file is.
    $myFileName = $_POST['MyFile']; //Retrieve file path and file name    
    $myfile_replace = str_replace('\\', '/', $myFileName);    //convert path for use with unix
    $myfile = basename($myfile_replace);    //extract file name from path
    $destination_file = "/".$myfile;  //where you want to throw the file on the webserver (relative to your login dir)
    // connection settings
    $ftp_server = "127.0.0.1";  //address of ftp server (leave out ftp://)
    $ftp_user_name = ""; // Username
    $ftp_user_pass = "";   // Password
    $conn_id = ftp_connect($ftp_server);        // set up basic connection
    // login with username and password, or give invalid user message
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("<h1>You do not have access to this ftp server!</h1>");
    $upload = ftp_put($conn_id, $destination_file, $file, FTP_BINARY);  // upload the file
    if (!$upload) {  // check upload status
        echo "<h2>FTP upload of $myFileName has failed!</h2> <br />";
    }
/*
    // try to delete $file
    if (ftp_delete($conn_id, $destination_file)) {
        echo "$destination_file has been deleted!\n";
    } else {
        echo "Could not delete $destination_file!\n";
    }
*/
ftp_close($conn_id); // close the FTP stream

?>
<form name="form" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
Please choose a file: <input type="file" name="file" accept="text/plain" onChange="MyFile.value=file.value">
<input name="MyFile" type="hidden" id="MyFile" tabindex="99" size="1" />
<input type="submit" name="submit" value="upload" style="vertical-align:middle"/><br/><br/>
</form>