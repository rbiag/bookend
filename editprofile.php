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
		<title> Edit Profile </title>
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
			<h1> Edit Profile </h1>
			<form action="process-edit-profile.php" enctype="multipart/form-data" method="POST" >
				<p> Name </p>
				<input name="name" type="input" value="<?php echo($row["name"]); ?>"/>
				<p> Bio </p>
				<textarea name="bio" type="input"> <?php echo($row["bio"]); ?> </textarea>
				<br>
				<input type="hidden" name="userId" value="<?php echo($row["userId"]); ?>" />

				<input type="submit" value="Update"/>
			</form>
		</main>
	</body>
</html>
