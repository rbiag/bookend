<?php session_start(); 

include("includes/db-config.php");

$userId = $_SESSION["userId"];
$bookId = $_GET["bookId"];

$stmt = $pdo->prepare("SELECT * FROM `books` WHERE `bookId` = '$bookId'");
$stmt->execute();
$row = $stmt->fetch();

?>

<html>
<head>
	<title> <?php echo($row['bookName']); ?> </title>
	<meta charset="utf-8">
	<meta name="keywords" content=" ">

	<link rel="stylesheet" media="screen" href="main.css" />

	<link href="https://fonts.googleapis.com/css?family=Raleway|Roboto&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
</head>
<body> 
<header>
	<?php include("includes/header.php") ?>
</header>
<main>
<section id="bookPage"> 
	<div id="bookCover">
		<img src="<?php echo($row['bookPic']);?>" class="mainCover"/>
		<div class="addToList"> 
			<h3> Add to a List </h3>
			<form action="list-process.php" method="POST">
				<select name="listName">
					<option value="wishlist"> Wishlist </option>
					<option value="currentlyReading"> Currently Reading </option>
					<option value="read"> Read </option>
				</select>
				<input type="hidden" name="bookId" value="<?php echo($bookId); ?>" >
				<input type="submit" id="addToListBtn" value="Add to List">
			</form>
			<a href="#bookPageDetails"> <button> Rate It </button> </a> <!-- anchor to review section-->
		</div>
	</div>
	<div id="bookInfo">
		<h1> <?php echo($row['bookName']); ?> </h1>
		<p class="author"> <?php echo($row['bookAuthor']); ?> </p>
		<?php
		// CALCULATE AVERAGE RATING FOR BOOK
		$rateAvg = $pdo->prepare("SELECT AVG(`rating`) as avrg FROM `bookRating` WHERE `bookId` = '$bookId'");
		$rateAvg->execute();
		$rowAVG = $rateAvg->fetch();

		//COUNT TOTAL NUMBER OF REVIEWS FOR BOOK
		$reviewCount = $pdo->prepare("SELECT COUNT(`reviewId`) as reviewTotal FROM `bookRating` WHERE `bookId` = '$bookId'");
		$reviewCount->execute();
		$reviewRow = $reviewCount->fetch();

		$totalReviews = $reviewRow["reviewTotal"];
		$bookRating = $rowAVG["avrg"];

		?> <section id="ratings"> 
		<div>
		<?php
		// NUMBER OF STARS THAT SHOULD BE FILLED IN BASED ON RATING AVERAGE
		if($bookRating <= 1){ ?>
			<spanspan class="stars"> 
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star"></span>
			<span class="fa fa-star star"></span>
			<span class="fa fa-star star"></span>
			<span class="fa fa-star star"></span>
			</spanspan>
		<?php } else if ($bookRating <= 2){ ?>
			<span class="stars"> 
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star"></span>
			<span class="fa fa-star star"></span>
			<span class="fa fa-star star"></span>
			</span>
		<?php } else if ($bookRating <= 3){ ?>
			<span class="stars"> 
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star"></span>
			<span class="fa fa-star star"></span>
			</span>
		<?php } else if ($bookRating <= 4){ ?>
			<span class="stars"> 
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star"></span>
			</span>
		<?php } else if ($bookRating <= 5 || $bookRating >= 5){ ?>
			<span class="stars"> 
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			<span class="fa fa-star star starSelected"></span>
			</span>
		<?php }
		// ROUND THE AVEGERAGE BOOK RATING
		echo(round($bookRating, 1, PHP_ROUND_HALF_UP)); ?>
		</div>
		<div>
			<!-- DISPLAY TOTAL NUMBER OF REVIEWS -->
			<p> <?php echo($totalReviews." Reviews"); ?> </p>
		</div>
	 </section> 

	 <section class="userReadList"> 
	 <?php 
	 // DISPLAY MAX OF 5 ICONS OF PEOPLE WHO HAVE READ THE BOOK
		$stmtRead = $pdo->prepare("SELECT * 
			FROM `user_lists` 
			INNER JOIN `user`
			ON `user_lists`.`userId` = `user`.`userId`
			WHERE `bookId` = '$bookId'
			AND `progress`=100
			ORDER BY RAND() LIMIT 5");
		$stmtRead->execute();

		while($rowRead = $stmtRead->fetch()){
			?> <img src="<?php echo($rowRead['profilePic']); ?>" class="userIcon"/> 
			<?php
			$userRead = $rowRead['name'];
		}

		// DISPLAY ONE USER WHO HAS READ THE BOOK + HOW MANY OTHER USERS HAVE READ IT
		$stmtReadCount = $pdo->prepare("SELECT COUNT(`bookId`) as total FROM `user_lists` WHERE `bookId` = '$bookId' AND `progress` = 100 ");
		$stmtReadCount->execute();
		$rowReadCount = $stmtReadCount->fetch();

		echo($userRead ." and " . ($rowReadCount["total"]-1). " others have read this book");

		?>
		</section>

		<p> <?php echo($row['bookDescription']); ?> </p>
	
	</div>
</section>

<section id="bookPageDetails">
	
	<div id="bookPageTabs">
		<div class="selectedTab" id="reviewsTab"> <h2> Reviews </h2> </div>
		<div id="detailsTab"> <h2> Details </h2> </div> 
		<div id="relatedTab"> <h2> Related Books </h2> </div>
	</div>

	<div>
	<div id="bookReviewTab">
		<!-- FORM FOR POSTING A REVIEW -->
		<h3> Post a Review </h3>
		<form>
			<div id="myReview"> 
			<p> My Rating: </p>
				<div class="stars">
				<label for="star1"> <span class="fa fa-star star ratingStar" id="starIcon1" required></span> </label> <input type="radio" value="1" name="rating" id="star1">
				<label for="star2"> <span class="fa fa-star star ratingStar" id="starIcon2"></span> </label> <input type="radio" value="2" name="rating" id="star2">
				<label for="star3"> <span class="fa fa-star star ratingStar" id="starIcon3"></span> </label> <input type="radio" value="3" name="rating" id="star3">
				<label for="star4"> <span class="fa fa-star star ratingStar" id="starIcon4"></span> </label> <input type="radio" value="4" name="rating" id="star4">
				<label for="star5"> <span class="fa fa-star star ratingStar" id="starIcon5"></span> </label> <input type="radio" value="5" name="rating" id="star5">
				</div>
			</div>
			<textarea name="reviewContent" type="text" required class="commentInput" placeholder="What did you think of <?php echo($row['bookName']); ?>?"></textarea>
			<input type="hidden" name="bookId" value="<?php echo($bookId); ?>" />
			<br>
			<button id="reviewBtn"> Post </button>
		</form>
		
		<div id="newReview"> 

		</div>

		<?php 
		// REVIEWS FROM OTHER USERS
			$stmtReview = $pdo->prepare("SELECT * 
				FROM `bookRating`
				INNER JOIN `user`
				ON `bookRating`.`userId` = `user`.`userId`
				WHERE `bookId` = '$bookId' ");
			$stmtReview->execute();

			?> <div class="userPost"> <?php
			while($rowReview = $stmtReview->fetch()){ ?>
				<div class='postBlock'>
				<div class="postMain">
					<div class="postImg">
						<img src="<?php echo($rowReview["profilePic"]); ?>" />
					</div>
						<div class="postContent">
						<h3> <?php echo($rowReview["name"]); ?> </h3>
						<?php if($rowReview['rating'] <= 1){ ?>
					<div class="stars"> 
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star"></span>
					<span class="fa fa-star star"></span>
					<span class="fa fa-star star"></span>
					<span class="fa fa-star star"></span>
					</div>
				<?php } else if ($rowReview['rating'] <= 2){ ?>
					<div class="stars"> 
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star"></span>
					<span class="fa fa-star star"></span>
					<span class="fa fa-star star"></span>
					</div>
				<?php } else if ($rowReview['rating'] <= 3){ ?>
					<div class="stars"> 
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star"></span>
					<span class="fa fa-star star"></span>
					</div>
				<?php } else if ($rowReview['rating'] <= 4){ ?>
					<div class="stars"> 
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star"></span>
					</div>
				<?php } else if ($rowReview['rating'] <= 5 || $rowReview['rating'] >= 5){ ?>
					<div class="stars"> 
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					<span class="fa fa-star star starSelected"></span>
					</div>
				<?php } ?>
						<p class="postDate"> <?php echo($rowPost["reviewDate"]); ?> </p> 
						<p class="commentContent"> <?php echo($rowReview["reviewContent"]); ?> </p>
					</div>
				</div>
				<div class="postComments">
				<button value="<?php echo($rowReview['reviewId']); ?>" onclick="showComments(this); commentModal();"> Show Previous Comments </button>
				<form action="process-review-comment.php" method="POST"> 
					<textarea name="commentContent" type="text" required class="commentInput"></textarea>
					<br>
					<input type="hidden" name="reviewId" value="<?php echo($rowReview['reviewId'])?>" />
					<input type="hidden" name="bookId" value="<?php echo($bookId)?>" />
					<div class="sendComment"> <input type="submit" value="Send Comment"/> </div>
				</form>
				</div>
			</div>
				<!-- MODAL FOR VIEWING COMMENTS -->
				<div id="modal">
					<div class="modalContent">
						<h2> Post Comments </h2>
						<div id="commentSection"> </div>
					</div>
				</div>
			<?php } ?>
	</div>
	</div>

	<div>
	<div id="bookDetailsTab">
		<!-- BOOK DETAILS -->
		<div id="publishingInfo">
		<h3> Publishing Information </h3>
			<p> <?php echo($row['totalPages']); ?> pages</p>
			<p> Published: <?php echo($row['publishDate']); ?> </p>
			<p> By <?php echo($row['publishCompany'])?></p>
		</div>
		<div id="genres">
		<h3> Genres </h3>
		<?php
			$stmtGenre = $pdo->prepare("SELECT * FROM bookGenre WHERE `bookId` = '$bookId'");
			$stmtGenre->execute();

			while($rowGenre = $stmtGenre->fetch()){
				?> <div> <?php
				echo($rowGenre['genre']." ");
				?> </div> <?php
			}
		?>
		</div>
		<div id="aboutAuthor">
		<h3> About the Author </h3>
		<?php
		$authorId = $row['authorId'];
		$stmtAuthor = $pdo->prepare("SELECT * FROM `user` WHERE `userId` = '$authorId'");
		$stmtAuthor->execute();

		$rowAuthor = $stmtAuthor->fetch();

		?>

		<img src="<?php echo($rowAuthor['profilePic']); ?>" /> 
		<p> <?php echo($rowAuthor['bio']); ?></p>
		</div>
	</div>
	<div>
	</div>
		<!-- RELEATED BOOKS -->
		<div>
		<div class="bookList" id="bookRelatedTab">
		<?php
			$stmtRelated = $pdo->prepare("SELECT * FROM `books` WHERE `bookId` != '$bookId'");
			$stmtRelated->execute();

			while($rowRelated = $stmtRelated->fetch()){ ?> 
				<div class="bookContainer">
					<img src="<?php echo($rowRelated['bookPic']); ?>" class="bookThumbnail" /> 
					<h3 class="hiddenLink"> <a href="book.php?bookId=<?php echo($rowRelated["bookId"])?>"> <?php echo($rowRelated["bookName"]); ?> </a> </h3> 
					<p class="author"> <?php echo($rowRelated["bookAuthor"]); ?> </p>
				</div>
			<?php }
		?>
	</div>
	</div>
	</div>
</section>
</main>
<script src="book.js" type="text/javascript"></script>
</body>
</html>