<?php session_start(); 

$postId = $_POST['postId'];

include("includes/db-config.php");

$stmt = $pdo->prepare("SELECT * FROM `user_comments` INNER JOIN `user` ON `user_comments`.`userId` = `user`.`userId` WHERE `postId` = '$postId'");

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

echo($json);

?>