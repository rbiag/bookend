<?php session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$userId = $_SESSION['userId'];

include("includes/db-config.php");

$stmt = $pdo->prepare("UPDATE `user` SET `email`='$email',`password`='$password' WHERE `userId` = '$userId'");

$stmt->execute();

header("Location:home.php");

?>