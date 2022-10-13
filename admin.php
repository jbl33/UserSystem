<?php
    require_once 'connection.php';
    session_start();
    if(!isset($_SESSION['user']) or $_SESSION['user']['adminPermissions'] != 1) {
        session_start();
	    session_destroy();
	    header("location: index.php");
    }
?>
<html>
    <head>
        <title> FileUpload.One - Admin Panel </title>
        <script type="text/javascript" 
    src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>  
        <link rel="stylesheet" type="text/css" href="style/navigation.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
    <div id="nav">
<ul>
	<?php
		$query = $db->prepare("SELECT * FROM `pages` WHERE 1");
		$query->execute();
		$row = $query->fetchAll(PDO::FETCH_ASSOC);
		for($x = 0; $x < count($row); $x++) {
			if($row[$x]['adminPermissions'] <= $_SESSION['user']['adminPermissions']) {
				echo "<li> <a href='" . $row[$x]['href'] . "'> " . $row[$x]['tag'] . " </a> </li>";
			}
		}
		
	?>
</ul> 
</div>
<div class="content">
<h1 id='title'> Admin Panel </h1>
        <h2 class="table-description"> All Users </h2>
        <table id="user-table"> 
            <tr>
                <th> ID </th>
                <th> Name </th>
                <th> Email </th>
                <th> Created </th>
                <th> adminPermissions </th>
            </tr>
            <?php
                $select_all_stmt = $db->prepare("SELECT * FROM `users` WHERE 1;
                ");
                $select_all_stmt->execute();
                $row = $select_all_stmt->fetchAll(PDO::FETCH_ASSOC);
                for($x = 0; $x < count($row); $x++) {
                    echo "<tr><td> " . $row[$x]['id'] . " </td>";
                    echo "<td> " . $row[$x]['name'] . " </td>";
                    echo "<td> " . $row[$x]['email'] . " </td>";
                    echo "<td> " . $row[$x]['created'] . " </td>";
                    echo "<td> " . $row[$x]['adminPermissions'] . " </td></tr>";
                }
            ?>
        </table>
        <br>
        <br>
        <div class="search-user">
        <h2 class="table-description"> Search Users </h2>
        <input type="text" id="search-box" placeholder="james@email.com"></input> 
        <?php
        if(isset($_SESSION['user']['apiKey'])) {
            echo "<input type=\"text\" id=\"api-key\" value=\"". $_SESSION['user']['apiKey'] ."\"></input>";
        } else {
            echo "<input type=\"text\" id=\"api-key\" placeholder=\"". "A5SZtQBvJv2JMetm" ."\"></input>";
        }
        ?>
        <button id="search-btn"> Search User </button>
        <br> <p id="error-text"> </p>
        </div> <br>
        <div id="result-table"> </div>
        <script src="js/search.js"></script>
    </body>
</html>