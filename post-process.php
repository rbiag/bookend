<?php session_start();

$userId = $_SESSION["userId"];
$postContent = $_POST["postContent"];
$postDate = date("M d Y");

include("includes/db-config.php");

$stmt = $pdo->prepare("INSERT INTO `user_posts`(`postId`, `userId`, `postContent`, `postDate`) VALUES (NULL,'$userId','$postContent','$postDate')");

$stmt->execute();

header("Location: home.php");

?>