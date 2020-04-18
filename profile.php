<?php session_start(); 
include("includes/db-config.php");

$userId = $_GET["userId"];

$stmt = $pdo->prepare("SELECT * FROM `user` WHERE `userId` = '$userId'");
$stmt->execute();
$row = $stmt->fetch();

?>

<html>
<head>
	<title> Profile </title>
	<meta charset="utf-8">
	<meta name="keywords" content=" ">

	<link rel="stylesheet" media="screen" href="main.css" />

	<link href="https://fonts.googleapis.com/css?family=Raleway|Roboto&display=swap" rel="stylesheet">
	
</head>
<body> 
<header>
	<?php include("includes/header.php") ?>
</header>
<main>
<section id="profile">
	<section>
	<div class="profileBar">
		<img src="<?php echo($row["profilePic"]);?>"  class="profilePicBig"/>
		<h2> <?php echo($row["name"]); ?> </h2> 
		<p> <?php echo($row["bio"]); ?> </p>
		<?php if($_SESSION["userId"] === $row["userId"]){ ?>
			<a href="editprofile.php?userId=<?php echo($row["userId"])?>"> <button> Edit Profile </button> </a>
			<a href="editprofilepic.php?userId=<?php echo($row["userId"])?>"> <p class="hiddenLink"> Edit Picture </p> </a>
		<?php } ?>

	<?php 
		$userId = $_GET["userId"];
		$stmtCR = $pdo->prepare("SELECT * 
			FROM `user_lists` 
			INNER JOIN `books`
			ON `user_lists`.`bookId` = `books`.`bookId`
			WHERE `user_lists`.`userId` = '$userId' AND `listName` = 'currentlyReading'");
		$stmtCR->execute();
		$rowCR = $stmtCR->fetch();

	if($rowCR["listName"] === "currentlyReading") { ?> 
	<h2> Currently Reading </h2>
		 <img src="<?php echo($rowCR["bookPic"]); ?>" class="bookThumbnail"/> <?php
		echo("<p>");
		echo($rowCR["bookName"]);
		echo("</p><p>");
		?> By: <?php echo($rowCR["bookAuthor"]);
		echo("</p><p>");
		echo($rowCR["progress"]); ?>% Complete </p>
		<?php if($userId == $_SESSION['userId']) {?>
			<button id="progressBtn"> Update Status </button>
		<?php }
	}
		$bookId = $rowCR["bookId"];

		$stmtCR2 = $pdo->prepare("SELECT * FROM `books` WHERE `bookId` = '$bookId'");
		$stmtCR2->execute();
		$rowCR2 = $stmtCR2->fetch();
		$totalPages = $rowCR2["totalPages"];
	?>
</div>
		<div id="statusModal">
			<div class="statusModalContent">
				<h2> Update Status of <?php echo($rowCR['bookName']); ?>  </h2>
				<form action="process-update-status.php" method="POST" >
					<p> <input name="pageNumber" type="number" /> /<?php echo($totalPages); ?> Pages </p>
					<input type="hidden" name="bookId" value="<?php echo($rowCR["bookId"]); ?>" />
					<input type="hidden" name="totalPages" value="<?php echo($totalPages); ?>" />
					<input type="submit" value="Update"/>
				</form>
			</div>
		</div>
	</div>
</section>
<section>
	<div>
		<h1> <?php echo($row['name']);?> Has Read </h1>
		<?php
		$userId = $_GET['userId'];
		$stmtRead = $pdo->prepare("SELECT * 
			FROM `user_lists` 
			INNER JOIN `books`
			ON `user_lists`.`bookId` = `books`.`bookId`
			WHERE `user_lists`.`userId` = '$userId' AND `user_lists`.`listName` = 'read' LIMIT 3");
		$stmtRead->execute();

		?> <div class="bookList"> <?php
		while($rowRead = $stmtRead->fetch()){
			?> 
			<div class="bookContainer">
			<img src="<?php echo($rowRead["bookPic"]); ?>" class="bookThumbnail"/> <?php
			echo("<h3 class='hiddenLink'>");
			?> <a href="book.php?bookId=<?php echo($rowRead['bookId']); ?>"> <?php echo($rowRead["bookName"]); ?> </a> <?php
			echo("</h3><p class='author'>");
			?> By: <?php echo($rowRead["bookAuthor"]);
			echo("</p>");
			echo("</div>");
		}
		?>
		</div>
	</div>
	<div> 
		<h1> <?php echo($row['name']);?> Wants to Read </h1>
		<?php
		$userId = $_GET['userId'];
		$stmtWishlist = $pdo->prepare("SELECT * 
			FROM `user_lists` 
			INNER JOIN `books`
			ON `user_lists`.`bookId` = `books`.`bookId`
			WHERE `user_lists`.`userId` = '$userId' AND `user_lists`.`listName` = 'wishlist' LIMIT 3");
		$stmtWishlist->execute();

		?> <div class="bookList"> <?php
		while($rowWishlist = $stmtWishlist->fetch()){
			?> 
			<div class="bookContainer">
			<img src="<?php echo($rowWishlist["bookPic"]); ?>" class="bookThumbnail"/> <?php
			echo("<h3 class='hiddenLink'>");
			?> <a href="book.php?bookId=<?php echo($rowWishlist['bookId']); ?>"> <?php echo($rowWishlist["bookName"]); ?> </a> <?php
			echo("</h3><p class='author'>");
			?> By: <?php echo($rowWishlist["bookAuthor"]);
			echo("</p>");
			echo("</div>");
		}
		?>
		</div>
	</div>
</div>
</section>
</section>
</main>
<footer>
	<?php include("includes/footer.php") ?>
</footer>
<script>
	var progressBtn = document.getElementById("progressBtn");
	progressBtn.addEventListener("click", showProgress, false);

	var statusModal = document.getElementById("statusModal");

	function showProgress(e){
		statusModal.style.visibility = "visible";
	}

	window.onclick = function(event) {
	  	if (event.target == statusModal) {
	   		statusModal.style.visibility = "hidden";
	  	}
	}
</script>
</body>
</html>