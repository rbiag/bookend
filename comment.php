<?php session_start(); 

$postId = $_GET["postId"];

?>

<form action="process-comment.php" method="POST"> 
	<textarea name="commentContent" type="text" required></textarea>
	<input type="hidden" name="postId" value=<?php echo($postId)?> />
	<input type="hidden" name="postDate" />
	<input type="submit" />
</form>