<?php
require_once 'required/connection.php';
session_start();
if(!isset($_SESSION['user']['email'])) {
	session_start();
	session_destroy();
	header("location: index.php");
}
?>

<html>
    <head>
        <title> FileUpload.One - Files </title>
        <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	    <link rel="stylesheet" type="text/css" href="style/navigation.css">
	    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300&display=swap" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
		<h1 id="title"> Your Files </h1>
      <?php
	    if(isset($_SESSION['user']['apiKey'])) {
		    
	    } else {
			echo "Error loading your files. Try logging in and out.";
		}
	  ?>
	  <div id="result-display"></div>
    </div>
	<script>
		/*
			Grabbing PHP variables in Javascript / Needed for AJAX call
		*/
		var apiKey = "<?php if(isset($_SESSION['user']['apiKey'])) {echo $_SESSION['user']['apiKey']; }?>";
	</script>
	<script src="js/filesearch.js"> </script>
  </body>
</html>