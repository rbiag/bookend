var reviewsTab = document.getElementById("reviewsTab");
var bookReviewTab = document.getElementById("bookReviewTab");
reviewsTab.addEventListener("click", showReviews, false);

var detailsTab = document.getElementById("detailsTab");
var bookDetailsTab = document.getElementById("bookDetailsTab");
detailsTab.addEventListener("click", showDetails, false);

var relatedTab = document.getElementById("relatedTab");
var bookRelatedTab = document.getElementById("bookRelatedTab");
relatedTab.addEventListener("click", showRelated, false);

showReviews();

function showReviews(e){
	reviewsTab.setAttribute("class","selectedTab");
	detailsTab.classList.remove("selectedTab");
	relatedTab.classList.remove("selectedTab");

	bookReviewTab.style.visibility = "visible";
	bookDetailsTab.style.visibility = "hidden";
	bookRelatedTab.style.visibility = "hidden";
}

function showDetails(e){
	detailsTab.setAttribute("class","selectedTab");
	reviewsTab.classList.remove("selectedTab");
	relatedTab.classList.remove("selectedTab");

	bookReviewTab.style.visibility = "hidden";
	bookDetailsTab.style.visibility = "visible";
	bookRelatedTab.style.visibility = "hidden";
}

function showRelated(e){
	relatedTab.setAttribute("class","selectedTab");
	reviewsTab.classList.remove("selectedTab");
	detailsTab.classList.remove("selectedTab");

	bookReviewTab.style.visibility = "hidden";
	bookDetailsTab.style.visibility = "hidden";
	bookRelatedTab.style.visibility = "visible";
}

var reviewBtn = document.getElementById("reviewBtn");
bookId = document.forms[1]["bookId"];

reviewBtn.addEventListener("click", postReview, false);

function postReview(e){
	console.log("submitted");

	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function(e){
		console.log(xhr.readyState);
		if(xhr.readyState === 4){
			var responseJSON = JSON.parse(xhr.responseText);
			console.log(responseJSON.success);
			if(responseJSON.success == "true"){
				var newReview = document.getElementById("newReview").innerHTML = ' ';
				var reviewUserBlock = document.createElement("h4");
				var reviewDateBlock = document.createElement("p");
				var reviewContentBlock = document.createElement("p");
				
				var reviewUser = document.createTextNode(responseJSON[i]["name"]);
				var reviewDate = document.createTextNode(responseJSON[i]["reviewDate"]);
				var reviewContent = document.createTextNode(responseJSON[i]["reviewContent"]);

				reviewUserBlock.appendChild(reviewUser);
				reviewDateBlock.appendChild(reviewDate);
				reviewContentBlock.appendChild(reviewContent);

				newReview.appendChild(reviewUserBlock);
				newReview.appendChild(reviewDateBlock);
				newReview.appendChild(reviewContentBlock);
			}
		}
	};

	var rating = document.forms[2]["rating"];
	var reviewContent = document.forms[2]["reviewContent"];
	xhr.open("POST","review-process.php", true);
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("rating="+rating.value+"&reviewContent="+reviewContent.value+"&bookId="+bookId.value);
}

var star1 = document.getElementById("starIcon1");
var star2 = document.getElementById("starIcon2");
var star3 = document.getElementById("starIcon3");
var star4 = document.getElementById("starIcon4");
var star5 = document.getElementById("starIcon5");

star1.addEventListener("click", select1, false);
star2.addEventListener("click", select2, false);
star3.addEventListener("click", select3, false);
star4.addEventListener("click", select4, false);
star5.addEventListener("click", select5, false);

function select1(e){
	star1.setAttribute("id","ratingStarSelected");
}

function select2(e){
	star1.setAttribute("id","ratingStarSelected");
	star2.setAttribute("id","ratingStarSelected");
}

function select3(e){
	star1.setAttribute("id","ratingStarSelected");
	star2.setAttribute("id","ratingStarSelected");
	star3.setAttribute("id","ratingStarSelected");
}

function select4(e){
	star1.setAttribute("id","ratingStarSelected");
	star2.setAttribute("id","ratingStarSelected");
	star3.setAttribute("id","ratingStarSelected");
	star4.setAttribute("id","ratingStarSelected");
}

function select5(e){
	star1.setAttribute("id","ratingStarSelected");
	star2.setAttribute("id","ratingStarSelected");
	star3.setAttribute("id","ratingStarSelected");
	star4.setAttribute("id","ratingStarSelected");
	star5.setAttribute("id","ratingStarSelected");
}

var commentSection = document.getElementById("commentSection");
	commentSection.innerHTML = '';

function showComments(e){
	reviewId = e.value;
	console.log(reviewId);

	var xhr = new XMLHttpRequest();

	xhr.onreadystatechange = function(e){
		console.log(xhr.readyState);
		if(xhr.readyState === 4){
			var responseJSON = JSON.parse(xhr.responseText);
			for(var i=0; i<responseJSON.length; i++){
				var commentImg = (responseJSON[i]["profilePic"]);
				var commentName = document.createTextNode(responseJSON[i]["name"]);
				var commentDate = document.createTextNode(responseJSON[i]["commentDate"]);
				var commentContent = document.createTextNode(responseJSON[i]["commentContent"]);

				var commentImgBlock = document.createElement("img");
				var commentNameBlock = document.createElement("h3");
				var commentDateBlock = document.createElement("p");
				var commentContentBlock = document.createElement("p");

				commentImgBlock.setAttribute("src", commentImg);
				commentNameBlock.appendChild(commentName);
				commentDateBlock.appendChild(commentDate);
				commentContentBlock.appendChild(commentContent)

				commentSection.appendChild(commentImgBlock);
				commentSection.appendChild(commentNameBlock);
				commentSection.appendChild(commentDateBlock);
				commentSection.appendChild(commentContentBlock);
			}
		}
	};

	xhr.open("POST", "review-show-comments.php", true);
	xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhr.send("reviewId="+reviewId);
}

var modal = document.getElementById("modal");
var span = document.getElementsByClassName("close")[0];

function commentModal(e){
	modal.style.visibility = "visible";
}

function close(e){
	modal.style.visibility = "hidden";
}

window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.visibility = "hidden";
	}
}