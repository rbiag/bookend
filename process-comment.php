<?php session_start(); 

$postId = $_POST["postId"];
$commentContent = $_POST["commentContent"];
$userId = $_SESSION["userId"];
$postDate = $postDate = date("M d Y");

include("includes/db-config.php");

$stmt = $pdo->prepare("INSERT INTO `user_comments`(`commentId`, `postId`, `userId`, `commentContent`, `commentDate`) VALUES (NULL,'$postId','$userId','$commentContent','$postDate')");

$stmt->execute();

header("Location: home.php");

?>