<?php

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$bio = "Write something about yourself";
$profilePic = "images/default.png";

include("includes/db-config.php");

$stmt = $pdo->prepare("INSERT INTO `user`(`userId`, `name`, `email`, `password`, `bio`, `profilePic`,`userType`) VALUES (NULL,'$name','$email','$password','$bio','$profilePic','public');");

$stmt->execute();

?>
