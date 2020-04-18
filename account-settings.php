<?php

session_start();

$userId = $_GET["userId"];

include("includes/db-config.php");

$stmt = $pdo->prepare("SELECT * FROM `user` WHERE `userId` = $userId");

$stmt->execute();

$row = $stmt->fetch();

?>

<html>
	<head>
		<title> Account Settings </title>
		<meta charset="utf-8" />
		<meta name="description" content=" ">
		<meta name="keywords" content=" ">

		<link rel="stylesheet" media="screen" href="main.css" />

		<link href="https://fonts.googleapis.com/css?family=Raleway|Roboto&display=swap" rel="stylesheet">

	</head>
	<body>
		<header>
			<?php include("includes/header.php") ?>
		</header>
		<main>
			<h1> Account Settings </h1>
			<form action="process-account-settings.php" enctype="multipart/form-data" method="POST" >
				<p> Email </p>
				<input name="email" type="input" value="<?php echo($row["email"]); ?>"/>
				<p> Password </p>
				<input name="password" type="input" value="<?php echo($row["password"]); ?>" />
				<br>
				<input type="hidden" name="userId" value="<?php echo($row["userId"]); ?>" />

				<input type="submit" value="Update"/>
			</form>
		</main>
	</body>
</html>
