<?php session_start(); 

include("includes/db-config.php");

$userId = $_SESSION["userId"];

$stmt = $pdo->prepare("SELECT * FROM `user` WHERE `userId` = '$userId'");
$stmt->execute();
$row = $stmt->fetch();

?>

<html>
<head>
	<title> Bookend </title>
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
<section id="homepage">
	<div class="profileBar">
	<?php if(isset($_SESSION["userId"])){ ?>

		<img src="<?php echo($row["profilePic"]);?>" class="profilePicBig"/> <br>
		<h2> <?php echo($row["name"]); ?> </h2>
		<p> <?php echo($row["bio"]); ?> </p>
			<a href="editprofile.php?userId=<?php echo($row["userId"])?>"> <button> Edit Profile </button> </a>
			<a href="editprofilepic.php?userId=<?php echo($row["userId"])?>"> <p class="hiddenLink"> Edit Picture </p> </a>

	<h2> Currently Reading </h2>

	<?php
		$stmtCR = $pdo->prepare("SELECT * 
			FROM `user_lists` 
			INNER JOIN `books`
			ON `user_lists`.`bookId` = `books`.`bookId`
			WHERE `user_lists`.`userId` = $userId AND `listName` = 'currentlyReading'");
		$stmtCR->execute();
		$rowCR = $stmtCR->fetch();

		$bookId = $rowCR["bookId"];

		if($rowCR["listName"] === "currentlyReading") { ?> 
		<img src="<?php echo($rowCR["bookPic"]); ?>" class="bookThumbnail"/> <?php
		?> <h4> <?php echo($rowCR["bookName"]); ?> </h4>
		<p> By: <?php echo($rowCR["bookAuthor"]); ?> </p>
		<p> <?php echo($rowCR["progress"]); ?>% Complete </p>
		<button id="progressBtn"> Update Status </button>
	<?php

		$stmtCR2 = $pdo->prepare("SELECT * FROM `books` WHERE `bookId` = '$bookId'");
		$stmtCR2->execute();
		$rowCR2 = $stmtCR2->fetch();
		$totalPages = $rowCR2["totalPages"];

	?>
		<div id="statusModal">
			<div class="statusModalContent">
				<h2> Update Status of <?php echo($rowCR2['bookName']); ?>  </h2>
				<form action="process-update-status.php" method="POST" >
					<p> <input name="pageNumber" type="number"/> /<?php echo($totalPages); ?> Pages </p>
					<input type="hidden" name="bookId" value="<?php echo($rowCR2["bookId"]); ?>" />
					<input type="hidden" name="totalPages" value="<?php echo($totalPages); ?>" />
					<input type="submit" value="Update"/>
				</form>
			</div>
		</div>
	<?php } else { ?>
			<p> Looks like you're not reading anything yet, but don't worry we can help fix that! Try searching for a book to get started. </p>
	<?php } ?> 
	</div>
	<div class="communityPosts">
		<h1> Community Posts </h1>
		<!-- CREATE A POST -->
		<form method="POST" action="post-process.php"> 
			<textarea name="postContent" type="text" required class="commentInput" placeholder="Create a Community Post"></textarea>
			<input type="hidden" name="userId" 
				value="<?php echo($row["userId"]); ?>" />
			<input type="hidden" name="postDate" />
			<div class="sendComment"> <input type="submit" value="Post" /> </div>
		</form>

		<!-- MODAL FOR SHOWING COMMENTS -->
			<div id="modal">
				<div class="modalContent">
				<h2> Post Comments </h2>
				<div id="commentSection"> </div>
				</div>
			</div>
		
		<?php 
			$stmtPost = $pdo->prepare("SELECT * 
				FROM `user_posts`
				INNER JOIN `user`
				ON `user_posts`.`userId` = `user`.`userId`");
			$stmtPost->execute();

		?> <div class="userPost"> <?php
			while($rowPost = $stmtPost->fetch()){ ?>
				<div class='postBlock'>
					<!-- DELETE POST BUTTON -->
				<?php if($rowPost['userId'] == $_SESSION['userId']){ ?> 
					<a href="delete.php?postId=<?php echo($rowPost["postId"]); ?>"> <button> x </button> </a>
				<?php } ?>

				<div class="postMain">
					<div class="postImg">
						<img src="<?php echo($rowPost["profilePic"]); ?>" />
					</div>
						<div class="postContent">
						<h3> <?php echo($rowPost["name"]); ?> </h3> 
						<p class="postDate"> <?php echo($rowPost["postDate"]); ?> </p> 
						<p class="commentContent"> <?php echo($rowPost["postContent"]); ?> </p>
					</div>
				</div>

				<div class="postComments">
				<button value="<?php echo($rowPost['postId']); ?>" onclick="showComments(this); commentModal();"> Show Previous Comments </button>
				<form action="process-comment.php" method="POST"> 
					<textarea name="commentContent" type="text" required class="commentInput"></textarea>
					<br>
					<input type="hidden" name="postId" value="<?php echo($rowPost['postId'])?>" />
					<div class="sendComment"> <input type="submit" value="Send Comment"/> </div>
				</form>
				</div>
				</div>
				<?php }
		} ?>
	</div>
</div>
</section>
</main>
<footer>
	<?php include("includes/footer.php") ?>
</footer>
<script> 
	var postId;

	function showComments(e){
		var commentSection = document.getElementById("commentSection");
		commentSection.innerHTML = '';

		postId = e.value;
		console.log(postId);

		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function(e){
			console.log(xhr.readyState);
			if(xhr.readyState === 4){
				var responseJSON = JSON.parse(xhr.responseText);
				for(var i=0; i<responseJSON.length; i++){
					var commentImg = (responseJSON[i]["profilePic"]);
					var commentName = document.createTextNode(responseJSON[i]["name"]);
					var commentDate = document.createTextNode(responseJSON[i]["commentDate"]);
					var commentContent = document.createTextNode(responseJSON[i]["commentContent"]);

					var commentImgBlock = document.createElement("img");
					var commentNameBlock = document.createElement("h3");
					var commentDateBlock = document.createElement("p");
					var commentContentBlock = document.createElement("p");

					commentImgBlock.setAttribute("src", commentImg);
					commentNameBlock.appendChild(commentName);
					commentDateBlock.appendChild(commentDate);
					commentContentBlock.appendChild(commentContent)

					commentSection.appendChild(commentImgBlock);
					commentSection.appendChild(commentNameBlock);
					commentSection.appendChild(commentDateBlock);
					commentSection.appendChild(commentContentBlock);
				}
			}
		};

		xhr.open("POST", "show-comments.php", true);
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xhr.send("postId="+postId);
	}

	var modal = document.getElementById("modal");


	function commentModal(e){
		modal.style.visibility = "visible";
	}
	
	window.onclick = function(event) {
	  	if (event.target == modal || event.target == statusModal) {
	   		modal.style.visibility = "hidden";
	   		statusModal.style.visibility = "hidden";
	  	}
	}

	var progressBtn = document.getElementById("progressBtn");
	progressBtn.addEventListener("click", showProgress, false);

	var statusModal = document.getElementById("statusModal");

	function showProgress(e){
		statusModal.style.visibility = "visible";
	}

</script>
</body>
</html>