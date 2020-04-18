<?php session_start(); 

$reviewId = $_GET["reviewId"];

?>

<form action="process-review-comment.php" method="POST"> 
	<textarea name="commentContent" type="text" required></textarea>
	<input type="hidden" name="reviewId" value=<?php echo($reviewId)?> />
	<input type="hidden" name="postDate" />
	<input type="submit" />
</form>