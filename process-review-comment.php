<?php session_start(); 

$reviewId = $_POST["reviewId"];
$commentContent = $_POST["commentContent"];
$bookId = $_POST["bookId"];
$userId = $_SESSION["userId"];
$postDate = $postDate = date("M d Y");

include("includes/db-config.php");

$stmt = $pdo->prepare("INSERT INTO `bookComments`(`commentId`, `reviewId`, `userId`, `commentContent`, `commentDate`) VALUES (NULL,'$reviewId','$userId','$commentContent','$postDate')");

$stmt->execute();

header("Location: book.php?bookId=$bookId");

?>