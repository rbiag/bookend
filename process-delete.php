<?php

session_start();

$postId = $_POST["postId"];

include("includes/db-config.php");

$stmtPost = $pdo->prepare("DELETE FROM `user_posts` WHERE `postId` = $postId");

$stmtPost->execute();

header("Location: home.php");

?>