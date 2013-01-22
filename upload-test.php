<?php
$folder = "/htdocs/uploads/";
if (is_uploaded_file($HTTP_POST_FILES['filename']['tmp_name']))  {   
    if (move_uploaded_file($HTTP_POST_FILES['filename']['tmp_name'], $folder.$HTTP_POST_FILES['filename']['name'])) {
         Echo "File uploaded";
    } else {
         Echo "File not moved to destination folder. Check permissions";
    };
} else {
     Echo "File is not uploaded.";
}; 
?>