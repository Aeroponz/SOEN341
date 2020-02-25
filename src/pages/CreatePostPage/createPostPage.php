<!DOCTYPE HTML>
<?php require_once('../functionBlocks/uploadBlock.php');?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width-device-width, initial-scale=1"/>
		<title>Blu - Create a Post</title>
		<link rel="stylesheet" type="text/css" href="/SOEN341/src/pages/FunctionBlocks/uploadBlockCSS.css">
	
	</head>
	<body>
		
		
		<div id = "submit_post" class = "upload_block">
			<?php
				//Outputs a custom message depending if user attempted to post nothing.
				if(isset($_GET["source"])) {
					if($_GET["source"] == 'empty'){
						echo "<p class = \"upload_warning\"> You cannot submit an empty post!</p>";
					}
				}				
			?>
			<form method="POST" action="/SOEN341/src/db/uploadPostToDB.php" enctype="multipart/form-data">
				<input type="file" id="fileinput" onchange="validateUpload();" name="postImage"><br>
				<input type="text" id="textinput" onchange="validateUpload();" name="postText" placeholder="Your text here.">
				<input type="submit" id="submitbutton" name="submit_image" value="Upload">
			</form>

			<div id="warnings"></div>
			
			<script type="text/javascript" src="/SOEN341/src/pages/FunctionBlocks/validUpload.js"></script>
		</div>
		
		
	</body>
</html>