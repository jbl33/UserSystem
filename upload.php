<?php
require_once 'connection.php';
session_start();
if(!isset($_SESSION['user']['email'])) {
	session_start();
	session_destroy();
	header("location: index.php");
}
?>

<html>
    <head>
        <title> FileUpload.One - Upload a File </title>
        <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	    <link rel="stylesheet" type="text/css" href="style/navigation.css">
	    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>  
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
    <h1 id="title"><br> <b> Upload a File </b> </h1><br>
      <div class="mb-3">
          <label for="fileName" class="form-label">Name</label>
          <input type="text" id="fileName" class="form-control" placeholder="My awesome file" style="max-width:50%;margin-left:25%">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password (optional)</label>
          <input type="password" id="password" class="form-control" placeholder="" style="max-width:50%;margin-left:25%">
        </div>
        <div class="mb-3">
          <label for="file" class="form-label">File</label>
          <input type="file" id="file" class="form-control" name="file" style="max-width:50%;margin-left:25%">
          </div>
			<button onclick="submit()" id="uploadButton" class="btn btn-primary">Upload</button>
            <p id="response"></p>
    </div>
  </body>
  <script>
    var fileSelector = document.getElementById("file");
    fileSelector.onchange = function() {
        if(this.files[0].size > 5368709120){
            document.getElementById("response").innerHTML = "<p style='color:red'> Error: File is too big! </p>";
            this.value = "";
        } else {
            if(document.getElementById("response") != null) {
                document.getElementById("response").innerHTML = "";
            }
        }
    };
    function submit() {
        if($("#fileName").val() == "") {
            document.getElementById("response").innerHTML = "<p style='color:red'> File name not set! </p>";
        } else if(document.getElementById("file").files[0] == null) {
            document.getElementById("response").innerHTML = "<p style='color:red'> File not selected </p>";
        } else {
            // Check if password is present and if so put it in database
            var usePassword;
            var filePassword;

            if($("#password").val() == "") {
                usePassword = 0;
                filePassword = "";
            } else {
                filePassword = $("#password").val();
            }
            // Good to submit ajax request here
            // Currently a base ajax request example below
            $.ajax({
            url: "script.php",
            data: { param1: "value1", param2: "value2" },
            type: "GET",
            context: document.body
            }).done(function() {
            
            });

        }
    }
    </script>
</html>