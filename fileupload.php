<?php
require_once 'connection.php';
    if(isset($_FILES['file'])) {
        $targetDir = "uploads/"; 
        $fileName = basename($_FILES['file']['name']); 
        $targetFilePath = $targetDir.$fileName; 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){ 
            echo "Uploaded file.";
            /*
                Here is where MYSQL table data should be inserted with user id, password, location.
            */
        }  
        } else {
            throw new Exception("File upload error.");
        }
?>