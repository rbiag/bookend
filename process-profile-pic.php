<?php session_start();

$userId = $_SESSION['userId'];

include("includes/db-config.php");

$uploaddir = "images/";
$uploadfile = $uploaddir . basename($_FILES['image']['name']);

if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {

$stmt = $pdo->prepare("UPDATE `user` SET `profilePic` ='$uploadfile' WHERE `userId` = '$userId'");

$stmt->execute();

header("Location:editprofilepic.php?userId=$userId");

} else {
	echo("error uploading file please try again");
}

?>