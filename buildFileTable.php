<?php
    require_once("required/connection.php");
    if(isset($_GET['apiKey'])) {
        $select_stmt = $db->prepare("SELECT * from users WHERE apiKey LIKE :apiKey LIMIT 1");
		$select_stmt->execute([
			':apiKey' => $_GET['apiKey']
		]);
		$row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($row) == 0) {
            echo "Unauthorized. Invalid API key.";
        } else {
        $query = $db->prepare("SELECT * FROM `files` WHERE `creatorAPIKey` = \"" . $_GET['apiKey'] . "\";");
        $query->execute();
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        if(count($row) == 0) {
            echo "<h2> You have no files. Upload a file now! </h2>";
        } else {
            /*
            Building HTML table from response of MYSQL call
            */
            echo "<table class='styled-table'><thead>";
                echo "<tr>
                        <th> File Name </th>
                        <th> File ID </th>
                        <th> File Size </th>
                        <th> Date Uploaded </th>
                        <th> File Extension </th>
                        <th> Download </th>
                    </tr> </thead>";
            for($x = 0; $x < count($row); $x++) {
                if(file_exists($row[$x]['fileLocation'])) {
                        echo "<tr><td> " . $row[$x]['fileName'] . " </td>";
                        echo "<td> " . $row[$x]['fileID'] . " </td>";
                        echo "<td> " . human_filesize(filesize($row[$x]['fileLocation'])) . "</td>";
                        echo "<td> " . $row[$x]['dateUploaded'] . "</td>";
                        $fileType = "." .explode(".", $row[$x]['fileLocation'])[(count(explode(".", $row[$x]['fileLocation'])) - 1)];
                        echo "<td> " . $fileType . " </td>";
                        /*
                            Check if password is null
                            If null -> send one link
                            Otherwise -> collect password
                        */
                        $dlLink = "download.php?id=" . $row[$x]['fileID'] . "?apiKey=" . $_GET['apiKey'];
                        echo "<td><a href='" . $dlLink . "' target='_blank'>Download</a></td></tr>";
                } else {
                    /*
                        Deletes the row from MYSQL if the file no longer exists.
                    */
                    $delete_statement = $db->prepare("DELETE FROM `files` WHERE `fileID`= " . $row[$x]['fileID'] . ";");
                    $delete_statement->execute();
                }
            }
            echo "</table>";
        }
    }
}

/*
    Contribution found from http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
    Converts an integer of bytes into a readable size
*/
    function human_filesize($bytes, $dec = 2) {
        $size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }
?>