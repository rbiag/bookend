<?php  

?>

<html>
<head>
	<title> Bookend </title>
	<meta charset="utf-8">
	<meta name="keywords" content=" ">

	<link rel="stylesheet" media="screen" href="landing.css" />

	<link href="https://fonts.googleapis.com/css?family=Raleway|Roboto&display=swap" rel="stylesheet">
	
</head>
<body> 
<header>
	<?php include("includes/header.php") ?>
</header>
<main>
	<section id="featured"> 
		<img src="images/featured.jpg" id="featuredImg">
		<div id="featuredContent">
			<h2> Featured </h2>
			<h1> Sabrina & Corina </h1>
			<p> Kali Fajardo-Anstine </p>
			<button> Add to Wishlist </button>
		</div>
	</section>
	<section>
		<h1> Trending Now </h1>
		<div class="bookList">
		<?php

		include("includes/db-config.php");

			$stmt = $pdo->prepare("SELECT * FROM `books` ORDER BY RAND() LIMIT 5");
			$stmt->execute();

			while($row = $stmt->fetch()){
				?> 
				<div class="bookContainer">
					<img src="<?php echo($row['bookPic']); ?>" class="bookThumbnail" /> 
					<a href="book.php?bookId=<?php echo($row["bookId"])?>"> <h3> <?php echo($row["bookName"]); ?> </h3> </a>
					<p class="author"> <?php echo($row["bookAuthor"]); ?> </p>
				</div>
			<?php }
		?>
	</div>
	</section>
	<section id="CTA"> 
		<h1> Join the Club </h1>
		<p> Becoming a Bookend memeber only takes a few clicks and provides acess to biggest online book community.</p>
		<a href="signup.php"> <button> Sign Up Now </button> </a>
	</section>
	<section>
	<h1> New this Month </h1>
	<div class="bookList">
		<?php

			$stmt2 = $pdo->prepare("SELECT * FROM `books` ORDER BY RAND() LIMIT 5");
			$stmt2->execute();

			while($row2 = $stmt2->fetch()){
				?> 
				<div class="bookContainer">
					<img src="<?php echo($row2['bookPic']); ?>" class="bookThumbnail" /> 
					<a href="book.php?bookId=<?php echo($row2["bookId"])?>"> <h3> <?php echo($row2["bookName"]); ?> </h3> </a>
					<p class="author"> <?php echo($row2["bookAuthor"]); ?> </p>
				</div>
			<?php }
		?>
	</div>
	</section>
</main>
<footer>
	<?php include("includes/footer.php") ?>
</footer>
</body>
</html>