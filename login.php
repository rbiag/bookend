<?php 
	session_start();
?>
<html>
	<head>
		<title>Login</title>
		<meta charset="utf-8" />
		<meta name="keywords" content="login, signin">

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
			<h1> Login </h1>
			<form action="login-process.php" method="POST">
				<div class="formInput">
				Email
				<br>
				<input name="email" type="input" class="form-input"/>
				</div>
				<div class="formInput">
				Password
				<br>
				<input name="password" type="password" class="form-input"/>
				</div>
				<input type="submit" value="Login"/>
			</form>
			<p> Not a member yet? <a href="signup.php"> Sign Up </a> </p>
		</section>
		</main>
	</body>
</html>
