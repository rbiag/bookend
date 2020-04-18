<?php 
session_start();
?>
<html>
	<head>
		<title>User Sign Up</title>
		<meta charset="utf-8" />
		<meta name="keywords" content="signup, registration">

		<link rel="stylesheet" media="screen" href="main.css" />

		<link href="https://fonts.googleapis.com/css?family=Raleway|Roboto&display=swap" rel="stylesheet">

	</head>
	<body>
		<header>
			<?php include("includes/header.php") ?>
		</header>
		<main>
			<section class="formClass"> 
				<img src="images/logo-icon.png" />
				<h1> Sign Up </h1>
			<form action="process-signup.php" method="POST">
				<div class="formInput">
					Full Name
					<br>
					<input name="name" type="input" class="form-input"/>
				</div>
				<div class="formInput">
					Email
					<br>
					<input name="email" type="email" class="form-input"/>
				</div>
				<div class="formInput">
				Password
				<br>
				<input name="password" type="password" class="form-input"/>
				</div>
				<input type="submit" value="Sign Up"/>
			</form>
			<p> Already a member? <a href="login.php"> Login </a> </p>
		</main>
	</body>
</html>