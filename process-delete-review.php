<?php

session_start();

$reviewId = $_POST["reviewId"];

include("includes/db-config.php");

$stmtPost = $pdo->prepare("DELETE FROM `bookRating` WHERE `reviewId` = $reviewId");

$stmtPost->execute();

header("Location: home.php");

?>