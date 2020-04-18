<?php session_start(); 

$userId = $_SESSION["userId"];
$bookId = $_POST["bookId"];
$listName = $_POST["listName"];

include("includes/db-config.php");

$stmt = $pdo->prepare("SELECT * FROM `user_lists` WHERE `userId` = '$userId' AND `bookId` = '$bookId'");

$stmt->execute();

$row = $stmt->fetch();

if(($row["userId"]) && ($row["bookId"])){

	$stmtList = $pdo->prepare("UPDATE `user_lists` SET `listName`= '$listName' WHERE `userId`= '$userId' AND `bookId`='$bookId'");

	$stmtList->execute();

} else {
	
	if($listName == "read"){
		$stmtList = $pdo->prepare("INSERT INTO `user_lists`(`listId`, `listName`, `userId`, `bookId`, `progress`) VALUES (NULL, '$listName','$userId','$bookId', 100)");

		$stmtList->execute();
	} else {
		$stmtList = $pdo->prepare("INSERT INTO `user_lists`(`listId`, `listName`, `userId`, `bookId`, `progress`) VALUES (NULL, '$listName','$userId','$bookId', 0)");

		$stmtList->execute();
	}
}

header("Location:home.php");

?>