<?php

session_start(); 

$email = $_POST['email'];
$password = $_POST['password'];

include("includes/db-config.php");

$stmt = $pdo->prepare("SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'");

$stmt->execute();

$row = $stmt->fetch();

if($row){
	$_SESSION['userId'] = $row['userId'];
	header("Location: home.php");
} else {
	echo("The username or password you entered is incorrect please <a href='login.php'> try again</a>");
}

?>