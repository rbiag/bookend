<?php

include("db-config.php");

$userId = $_SESSION["userId"];

$stmtHead = $pdo->prepare("SELECT * FROM `user` WHERE `userId` = '$userId'");
$stmtHead->execute();
$rowHead = $stmtHead->fetch();

?>
<nav>
	<?php if(isset($_SESSION["userId"])){ ?>
	<a href="/bookend/home.php"> <img src="/bookend/images/logo.png" id="logo"> </a>
	<?php } else { ?> 
	<a href="/bookend/landing.php"> <img src="/bookend/images/logo.png" id="logo"> </a>
	<?php } ?>
	<?php if(isset($_SESSION["userId"])){ ?>
	<div> 
		<ul>
			<li> 
				<form action="process-search.php" method="GET">
				<input type="search" name="searchTerm"> 
				<select name="searchBy" class="searchSelect">
					<option value="bookName"> In Books </option>
					<option value="name"> In People </option>
				</select>
				</form>
			</li>
		</ul>
	</div>
	<div id="head-right">
		<ul>
			<section id="profileMenu"> 
			<li> <img src="<?php 
			echo($rowHead['profilePic'])?>" 
			class="headIcon" id="profileImg"/>
				<ul id="dropdownContent">
					<li> <a href="/bookend/profile.php?userId=<?php echo($row['userId']) ?>">View Profile </a> </li>
					<li> <a href="/bookend/account-settings.php?userId=<?php echo($row['userId']) ?>"> Account Settings </a> </li>
					<li> <a href="logout.php"> Logout </a> </li>
				</ul>
			</li>
			</section>
		</ul>
	<?php } else { ?>
	<div> 
		<ul> 
			<li> <a href="/bookend/signup.php"> Sign Up </a> </li>
			<li> <a href="/bookend/login.php"> Login </a> </li> 
		</ul>
	</div>
	<?php } ?>
	</div>
</nav>

<script>
	var dropdownContent = document.getElementById("dropdownContent");
	var profileMenu = document.getElementById("profileMenu");

	profileMenu.addEventListener("mouseover", showDropdown, false);
	profileMenu.addEventListener("mouseout", hideDropdown, false);

	function showDropdown(e){
		dropdownContent.style.visibility = "visible"
	}
	function hideDropdown(e){
		dropdownContent.style.visibility = "hidden"
	}
</script>