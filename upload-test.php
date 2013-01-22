<?php
if ($_FILES["image"]["error"] > 0)
  {
  echo "Error: " . $_FILES["image"]["error"] . "<br>";
  }
else
  {
  echo "Upload: " . $_FILES["image"]["name"] . "<br>";
  echo "Type: " . $_FILES["image"]["type"] . "<br>";
  echo "Size: " . ($_FILES["image"]["size"] / 1024) . " kB<br>";
  echo "Stored in: " . $_FILES["image"]["tmp_name"];
  }
  
  
  if (file_exists("uploads/" . $_FILES["image"]["name"])) 
      {
      echo $_FILES["image"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["image"]["tmp_name"],
      "uploads/" . $_FILES["image"]["name"]);
      echo "Stored in: " . "uploads/" . $_FILES["image"]["name"];
      }
   
?> 
 