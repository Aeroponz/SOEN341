<!DOCTYPE HTML>
<?php require_once('../functionBlocks/uploadBlock.php');?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width-device-width, initial-scale=1"/>
		<title>Blu - Create a Post</title>
		<link rel="stylesheet" type="text/css" href="/SOEN341/src/pages/FunctionBlocks/uploadBlockCSS.css">
		<link rel="stylesheet" href="../css/FeedStyle.css"/>
		<link rel="stylesheet" href="createPostPageCSS.css"/>
	</head>
	
	<body>
		<!--startof main -->
		<div class="FeedPage">
        <?php include '../Header/Header.html'; ?>
        <div class="main_upload">
			
			<!-- upload block -->
			<div id = "submit_post" class = "upload_block, Content">
				<p id="postgreeting">Share your images and thoughts online!</p>
				<form method="POST" action="/SOEN341/src/db/uploadPostToDB.php" enctype="multipart/form-data">
					<input type="file" id="fileinput" onchange="validateUpload();" name="postImage">
					<label for="fileinput" id="fl">Upload an image</label>
					<textarea type="text" id="textinput" onchange="validateUpload();" name="postText" placeholder="Your text here."></textarea>
					<input type="submit" id="submitbutton" name="submit_image" value="Post" style="font-weight:bold;">
				</form>

				<div id="warnings">
				<?php
					//Outputs a custom message depending if user attempted to post nothing.
					if(isset($_GET["source"])) {
						if($_GET["source"] == 'empty'){
							echo "<p class = \"upload_warning\" id=\"badPostWarning\"> * You cannot submit an empty post!</p>";
						}
					}				
				?>
				</div>
			
				<script type="text/javascript" src="/SOEN341/src/pages/FunctionBlocks/validUpload.js"></script>
			</div>
			<!-- endof upload block -->
			
			
			<div class="Sidebar">
                <div class="Feeds">
                    <h3 class="SidebarHeaders">Feeds</h3>
                    <br>
                    <a href="../HomePage/HomepageBase.php">
                        <img src="../GenericResources/Sidebar/home-icon.png">
                        <span>Home</span>
                        <br>
                    </a>			
                    <br>
                    <a href="../PopularFeedPage/PopularFeedPage.php">
                        <img src="../GenericResources/Sidebar/top-icon%20no%20flag.png">
                        <span>Popular</span>
                        <br>
                    </a>
                    <br>
                </div>
                <img src="../GenericResources/Sidebar/DividerTrending.png">
                <br>
                <div class="Trending">
                    <h3 class="SidebarHeaders">Trending</h3>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <span>1. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberOne</span>
                    </a>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <br>
                    <span>2. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberTwo</span>
                    </a>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <br>
                    <span>3. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberThree</span>
                    </a>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <br>
                    <span>4. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberFour</span>
                    </a>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <br>
                    <span>5. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberFive</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
	<!--endof main -->
		
	</body>
</html>
