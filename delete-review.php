<?php

session_start();

$reviewId = $_GET["reviewId"];

include("includes/db-config.php");

$stmtPost = $pdo->prepare("SELECT * FROM `bookComments` WHERE `reviewId` = $reviewId");

$stmtPost->execute();

?>

<html>
	<head>
		<title> Delete Post </title>
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
			<h1> Are You Sure You Would Like to Delete the Following Post? </h1>
			 <?php
			$rowPost = $stmtPost->fetch() ?>
			<div>  
				<p> <?php echo($row["reviewContent"]); ?> </p>
				<form method="POST" action="process-delete.php">
					<input type="hidden" name="postId" value="<?php echo($reviewId); ?>" />
					<input type="submit" value="confirm">
				</form>
		</div>
		</main>
	</body>
</html>
