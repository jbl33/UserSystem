<?php
require_once 'connection.php';
session_start();

	if(isset($_SESSION['user'])) {
	header("location: welcome.php");
	}

	if(isset($_REQUEST['login_btn'])) {
	$email = filter_var(strtolower($_REQUEST['email']), FILTER_SANITIZE_EMAIL);
	$password = strip_tags($_REQUEST['password']);
	if(empty($email)) {
		$errorMsg[] = "Must enter email";
	} else if(empty($password)) {
		$errorMsg[] = "Must enter password"; 
	} else {
		$select_stmt = $db->prepare("SELECT * from users WHERE email = :email LIMIT 1");
		$select_stmt->execute([
			':email' => $email
		]);
		$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

		if($select_stmt->rowCount() > 0) {

			if(password_verify($password, $row["password"])) {
				$_SESSION['user']['name'] = $row["name"];
				$_SESSION['user']['email'] = $row["email"];
				$_SESSION['user']['id'] = $row["id"];
				$_SESSION['user']['adminPermissions'] = $row['adminPermissions'];
				$_SESSION['user']['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['user']['apiKey'] = $row['apiKey'];
				header("location: welcome.php");
			} else {
				$errorMsg[] = 'Wrong email or password';
			} 
		} 
	}
	}
	

		
?>


<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<link href="style/style.css" rel="stylesheet">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	
	<title>Login</title>
</head>
<body>
	<?php
		if(isset($_REQUEST['msg'])) {
			echo "<p class='alert alert-warning'>".$_REQUEST['msg']."</p>";
		}
		if(isset($errorMsg)) {
			foreach($errorMsg as $loginError) {
			echo "<p class='alert alert-danger'>".$loginError."</p>";
		}
	}
	?>

	<div class="container">
	<div id="banner"> 
	  <h1><b> FileUpload.One </b></h1>
	  <h2> Temporarily upload your files for free - anytime! </h2>
	</div>
		<div id="spacing"> </div>
		<form action="index.php" method="post">
      <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" placeholder="jane@doe.com">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" placeholder="">
        </div>
			<button type="submit" name="login_btn" class="btn btn-primary">Login</button>
		</form>
    No Account? <a class="register" href="register.php">Register Instead</a>
	</div>
</body>
</html>