<?php
require_once 'required/connection.php';
    if(isset($_FILES['file']) and isset($_POST['apiKey']) and isset($_POST['password']) and isset($_POST['fileName'])) {
        $apiKey = $_POST['apiKey'];
        $targetDir = "uploads/"; 
        $fileName = basename($_FILES['file']['name']);
        $newFileName = generateRandomString(20) . "." . explode(".", $fileName)[1];
        $targetFilePath = $targetDir.$newFileName; 
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
        if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){ 
            echo "Uploaded file successfully!";
            /*
                Here is where MYSQL table data should be inserted with user id, password, location.
                Plan:
                fileName fileID creatorAPIKey fileLocation password dateUploaded
            */

        $query = $db->prepare("INSERT INTO `files` (`fileName`, `fileID`, `creatorAPIKey`, `fileLocation`, `password`, `dateUploaded`) VALUES " . 
            "('" . $_POST['fileName'] . "', NULL, '" . $_POST['apiKey'] . "', '" . $targetFilePath . "', '" . $_POST['password'] . "', " . 
        "current_timestamp())");
        $query->execute();
    } else {
        echo "Error uploading file.";
        }
        }  

        /*
            Method stolen from https://stackoverflow.com/questions/4356289/php-random-string-generator
            Didn't want to create a method for this
        */
        function generateRandomString($length = 10) {
            return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
        }
?>