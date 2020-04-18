<?php session_start(); 

$rating = $_POST["rating"];
$userId = $_SESSION["userId"];
$bookId = $_POST["bookId"];
$reviewContent = $_POST["reviewContent"];
$reviewDate = date("M d Y");

include("includes/db-config.php");

$stmt = $pdo->prepare("INSERT INTO `bookRating`(`reviewId`, `reviewContent`, `rating`, `bookId`, `userId`, `reviewDate`) VALUES (NULL,'$reviewContent','$rating','$bookId','$userId','$reviewDate')");

$stmt->execute();

?>