<?php
$allowedExts = array("jpg", "jpeg", "gif", "png");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("/uploads/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      
      $status = $_FILES["file"]["error"];
      echo "Status: $status <br /> <br />";
      
      if(!move_uploaded_file($_FILES["file"]["tmp_name"],
        "uploads/" . $_FILES["file"]["name"])) {
        throw new Exception("Faal");
      }
      
      
      
      
      if(file_exists("uploads/" . $_FILES["file"]["name"])) {
        echo "true";
      }
      else {
        echo "false";
      }
     
      }
    }
  }
else
  {
  echo "Invalid file";
  }
?>