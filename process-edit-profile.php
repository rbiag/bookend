<?php session_start();

$name = $_POST['name'];
$bio = $_POST['bio'];
$userId = $_SESSION['userId'];

include("includes/db-config.php");

$stmt = $pdo->prepare("UPDATE `user` SET `name`='$name',`bio`='$bio' WHERE `userId` = '$userId'");

$stmt->execute();

header("Location:home.php");

?>