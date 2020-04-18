<?php session_start();

$userId = $_SESSION['userId'];
$bookId = $_POST['bookId'];
$totalPages = $_POST['totalPages'];
$pageNumber = $_POST['pageNumber'];

$progress = ($pageNumber/$totalPages)*100;

include("includes/db-config.php");

if($progress < 100){
	$stmt = $pdo->prepare("UPDATE `user_lists` SET `listName`='currentlyReading',`userId`='$userId',`bookId`='$bookId',`progress`='$progress' WHERE `userId` = '$userId' AND `bookId` = '$bookId'");

	$stmt->execute();

	header("Location: home.php");

} else {
	$stmt = $pdo->prepare("UPDATE `user_lists` SET `listName`='read',`userId`='$userId',`bookId`='$bookId',`progress`='$progress' WHERE `userId` = '$userId' AND `bookId` = '$bookId'");

	$stmt->execute();

	header("Location: book.php?bookId=$bookId");
}

?>