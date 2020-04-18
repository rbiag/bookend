<?php session_start(); 

$reviewId = $_POST['reviewId'];

include("includes/db-config.php");

$stmt = $pdo->prepare("SELECT * FROM `bookComments` INNER JOIN `user` ON `bookComments`.`userId` = `user`.`userId` WHERE `reviewId` = '$reviewId'");

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);

echo($json);

?>