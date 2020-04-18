<?php
session_start();

$searchTerm = $_GET["searchTerm"];
$searchBy = $_GET["searchBy"];

include("includes/db-config.php");

?>

<html>
	<head>
		<title> Search </title>
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
		<?php
		// IF SEARCHING THROUGH BOOKS
		if($searchBy == "bookName"){
			// SELECT FROM/SEARCH THROUGH BOOKS AND CALCULATE NUMBER OF RESULTS
			$stmt = $pdo->prepare("SELECT * FROM `books` WHERE `bookName` LIKE '%$searchTerm%' OR `bookAuthor` LIKE '%$searchTerm%'");
			$stmt->execute();
			$stmtCount = $pdo->prepare("SELECT COUNT(`bookName`) as total FROM `books` WHERE `bookName` LIKE '%$searchTerm%' OR `bookAuthor` LIKE '%$searchTerm%'");
			$stmtCount->execute();
			$rowCount = $stmtCount->fetch();
			?> 

			<div class="searchTitle">
				<h1> Showing Results for <?php echo($searchTerm); ?> </h1>
				<h3> <?php echo($rowCount["total"]); ?> Books Found </h3> 
			</div>
			<div id="searchPageBook"> 
			<section id="searchInfo">
				<h3> Search Results Include </h3>
				<h4> Authors </h4>
				<?php 
				// SELECT/DISPLAY AUTHORS CORRESPONDING TO SEARCH RESULTS
					$stmtAuthor = $pdo->prepare("SELECT * FROM `books` WHERE `books`.`bookName` LIKE '%$searchTerm%' OR `books`.`bookAuthor` LIKE '%$searchTerm%' LIMIT 3");
					$stmtAuthor->execute();

					while($rowAuthor = $stmtAuthor->fetch()){
						echo($rowAuthor["bookAuthor"]);
						echo("<br>");
					}
				?>
				<h4> Genres </h4>
				<?php 
				// SELECT/DISPLAY GENRES CORESPONDING TO SEARCH RESULTS
					$stmtGenre = $pdo->prepare("SELECT * FROM `bookGenre` 
						INNER JOIN `books`
						ON `books`.`bookId` = `bookGenre`.`bookId`
						WHERE `books`.`bookName` LIKE '%$searchTerm%' OR `books`.`bookAuthor` LIKE '%$searchTerm%' LIMIT 3");
					$stmtGenre->execute();

					while($rowGenre = $stmtGenre->fetch()){
						echo($rowGenre["genre"]);
						echo("<br>");
					}
				?>
			</section>
			<section>
			<?php

			while($row = $stmt-> fetch()) { ?>
				<div class="searchResult">
					<div>
						<img src="<?php echo($row["bookPic"]); ?>" />
					</div>
					<div>
						<h2 class="hiddenLink"> <a href="book.php?bookId=<?php echo($row["bookId"]); ?>" >  <?php echo($row["bookName"]); ?> </a> </h2> 
						<p class="author"> <?php echo($row["bookAuthor"]); ?> </p>
						<p> <?php echo($row["bookPreview"]); ?> <a href="book.php?bookId=<?php echo($row["bookId"]); ?>"> ...Read More </a></p>
					</div>
				</div>
			<?php }

			} else if ($searchBy == "name") {
				$stmt = $pdo->prepare("SELECT * FROM `user` WHERE `name` LIKE '%$searchTerm%'");
				$stmt->execute();

				$stmtCount = $pdo->prepare("SELECT COUNT(`name`) as total FROM `user` WHERE `name` LIKE '%$searchTerm%'");
				$stmtCount->execute();
				$rowCount = $stmtCount->fetch();
			?> 
			
			<div class="searchTitle">
				<h1> Showing Results for <?php echo($searchTerm); ?> </h1>
				<h3> <?php echo($rowCount["total"]); ?> People Found </h3> 
			</div>
			<div> 
			<section>
			<?php
			while($row = $stmt-> fetch()) { ?>
				<div class="searchResult">
					<div>
						<img src="<?php echo($row["profilePic"]); ?>" />
					</div>
					<div>
						<h2 class="hiddenLink"> <a href="profile.php?userId=<?php echo($row["userId"]); ?>" >  <?php echo($row["name"]); ?> </a> </h2> 
						<p> <?php echo($row["bio"]); ?> </p>
						<a href="profile.php?userId=<?php echo($row["userId"]); ?>"> <button> View Profile </button> </a>
					</div>
				</div>
			<?php }
				}
			?>
		</section>
		</div>
	</main>
	<footer>
	<?php include("includes/footer.php") ?>
	</footer>
	</body>
</html>