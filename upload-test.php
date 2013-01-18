<?php
// the file name that should be uploaded
$filep=$_FILES['userfile']['tmp_name']; 
// ftp server
$ftp_server=$_POST['server'];
//ftp user name
$ftp_user_name=$_POST['user'];
//ftp username password
$ftp_user_pass=$_POST['password'];
//path to the folder on which you wanna upload the file
$paths=$_POST['pathserver'];
//the name of the file on the server after you upload the file
$name=$_FILES['userfile']['name'];

/*

//connect to ftp
$port = 21;
$conn_id=ftp_connect($ftp_server, $port);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
// check connection
if ((!$conn_id) || (!$login_result)) {
       echo "FTP connection has failed!";
       echo "Attempted to connect to $ftp_server for user $ftp_user_name....";
       exit;
} else {
       echo "Connected to $ftp_server, for user $ftp_user_name".".....";
}

// upload the file
$upload = ftp_put($conn_id, $paths.'/'.$name, $filep, FTP_BINARY);
 
// check upload status
if (!$upload) {
       echo "FTP upload has failed!";
} else {
       echo "Uploaded $name to $ftp_server ";
}

ftp_close($conn_id);

?>
*/

echo $name;



$userTest = 10361952;
$passTest = "Labrador19"
$conn = ssh2_connect('superinternetshop.nl', 22);
ssh2_auth_password($conn, $userTest, $passTest); 
$source = "‪C:\Users\Jordy\Documents\hoi2.tx"
$dest = "/datastore/webdb13IN4B/test/"
ssh2_scp_send($conn , $source, $dest); 

  // Add this to flush buffers/close session 

  ssh2_exec($objConnection, 'exit'); 
