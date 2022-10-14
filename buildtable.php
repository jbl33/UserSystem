<?php
require_once 'required/connection.php';
if(isset($_GET['apiKey'])) {
    $select_stmt = $db->prepare("SELECT * from users WHERE apiKey LIKE :apiKey LIMIT 1");
		$select_stmt->execute([
			':apiKey' => $_GET['apiKey']
		]);
		$row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($row) == 0) {
            echo "Unauthorized. Invalid API key.";
        } else {
            if($row[0]['adminPermissions'] == 1) {
            if(isset($_GET['query'])) {
                $select_stmt = $db->prepare("SELECT * from users WHERE email LIKE :email");
                $select_stmt->execute([
                    ':email' => "%" . $_GET['query'] . "%"
                ]);
                $row = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<table class='user-table' style='margin: 0 auto'>";
                echo "<tr>
                        <th> ID </th>
                        <th> Name </th>
                        <th> Email </th>
                        <th> Created </th>
                        <th> adminPermissions </th>
                    </tr> ";
                    for($x = 0; $x < count($row); $x++) {
                        echo "<tr><td> " . $row[$x]['id'] . " </td>";
                        echo "<td> " . $row[$x]['name'] . " </td>";
                        echo "<td> " . $row[$x]['email'] . " </td>";
                        echo "<td> " . $row[$x]['created'] . " </td>";
                        echo "<td> " . $row[$x]['adminPermissions'] . " </td></tr>";
                    }
                echo "</table>";
            } else {
                echo "Empty";
            }
        } else {
            echo "Unauthorized. No permissions";
        }
        }
    
} else {
    echo "Unauthorized";
}
?>