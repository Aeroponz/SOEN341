<!DOCTYPE html>
<?php
require_once('../../db/DBConfig.php'); //Must have at the top of any file that needs db connection.
session_start();

function follows($u_id2){
	global $loggenOnUser, $dbconn;
	$dbconn = Database::getConnection();
	$sql = "SELECT * FROM follow_tbl";  
	$result = $dbconn->query($sql);
	
	if ($result->num_rows > 0) {
		// each row
		while($row = $result->fetch_assoc()) {
			
			if($loggenOnUser == $row["u_id"]){
				if($u_id2 == $row["follows"]){
					return true;
				}	
			}
		}
	} 
	else{
		return false;
	}
}
?>

<!-- insert this when the image is clicked:
  <a href="viewPost.php?id=<?php //echo $p_id; ?>">
  -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewpost" content="width-device-width, initial-scale=1"/>
    <title>ViewPost Feed</title>
    <link rel="stylesheet" href="../css/viewPostStyle.css"/>
	<style>
		a { text-decoration: none; color: #000; }
	</style>
</head>
<body>
	<!-- get current user id & connect to DB-->
	<?php
	 if (isset($_SESSION["userID"])) {
		 $loggenOnUser = $_SESSION["userID"];
	 } else {
		 $loggenOnUser = " a public user";
	 }
	 $dbconn = Database::getConnection();
	 $tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	 $u_id = $loggenOnUser;
	 $p_id = 0;
	if(isset($_GET['id']) && $_GET['id'] !== ''){
	  $p_id = $_GET['id'];
	  //echo $p_id; //comment out echo when not debugging
	} 
	else {
	  //echo "failed";
	}
	
	$sql = "SELECT * FROM posts 
				INNER JOIN users on posts.u_id = users.u_id
				INNER JOIN user_profile on users.u_id = user_profile.u_id";
	$result = $dbconn->query($sql);

	$username = null;
	$TimeofPost = null;
	$image = null;
	$text = null;	
	$profile = "../GenericResources/Post_Frame/Avatar%20Picture%20Circle.png";
			
	
	if ($result->num_rows > 0) {
		// each row
		while($row = $result->fetch_assoc()) {
			if($row["p_id"]== $p_id){
				$u_id2 = $row["u_id"];
				$username = $row["name"];
				$TimeofPost = $row["posted_on"];
				$upvote = $row["upvote"];
				$downvote = $row["downvote"];
				$ranking = $upvote + $downvote;
				
				if(follows($u_id2))
				{
					$followLabel = 'UnFollow';
				}
				else
				{
					$followLabel = 'Follow';
				}
				
				if($row["img_path"] != null)
				{
					$image = $row["img_path"];
				}
				else 
				{ 
					$image = null;
				}	
				
				if($row["txt_content"] != null)
				{
					$text = $row["txt_content"];
				}
				else 
				{ 
					$text = "";	
				}									
				
				if($row["pic"] != null)
				{
					$profile = $row["pic"];
				}
				else 
				{ 
					$profile = "../GenericResources/Post_Frame/Avatar%20Picture%20Circle.png";
				}
			}
		}
	}
	?>
	 
    <div class="FeedPage">
        <?php include '../Header/Header.html'; ?>
        <div class="Main">
            <div class="Posts">
                
                <div class="PostContent">
                    <figure>
					<?php 
							if($image != null)
							{ 
					?>
								<img src="../../db/<?php echo $image; ?>" alt="Image Failed to load">
				    <?php	}
							if($text != null)
							{ 
					?>
								<p><?php echo "$tab$text"; ?></p>
					<?php 	}
					?>
					
					<p></p>
					</figure>
                </div>
            </div>
			<div class="Comments">
                <div class="PostInfo"><br>
					<a aria-label="AccountPage_AvatarPic" class="Avatar">
						<img class="one" src= <?php echo $profile?>>
					</a>
					
					<a href="../UserPage/UserPage.php?id= <?php echo $u_id2; ?>" aria-label="OpUsername" class="Username">
						<h4 class="Username"><?php echo $username; ?></h4>
					</a>
					
					<a aria-label="follow_button" class="follow">
						<div id = "follow_user">
							<iframe name="follow" style="display:none;"></iframe>
							<form target= "follow" method="post" action="../../db/followToDB.php" enctype="multipart/form-data">
								<input type="hidden" name="u_id2" value="<?php echo $u_id2;?>"> 
								<input id="followbutton" onclick="return changeText('followbutton');" type="submit" value="<?php echo $followLabel;?>" /> 
							</form>
						</div>
					</a>
					
					<a aria-label="DeltaTime" class="TimeOfPost">
						<h6 class="TimeOfPost"><?php echo $TimeofPost; ?> </h6>
					</a>
				</div>
				
				<script type="text/javascript">
					function changeText(followId) {
						var follow = document.getElementById(followId);
						if(follow.value == 'Follow')
						{
							follow.value = 'Unfollow';
						}
						else{
							follow.value = 'Follow';
						}
						return true;
					};
				</script>
				
				<div class="comments_wrap">
				<?php
					$sql = "SELECT * FROM comments 
							INNER JOIN users ON comments.u_id = users.u_id
							INNER JOIN user_profile ON users.u_id = user_profile.u_id
							WHERE p_id = '$p_id'
							ORDER BY 
								posted_on DESC";
					$result = $dbconn->query($sql); 
					if (!$result) {
						trigger_error('Invalid query: ' . $dbconn->error);
					}
					
					if ($result->num_rows > 0) {
						// each row
						while($row = $result->fetch_assoc()) {
							$username = $row["name"];
							$u_id2 = $row["u_id"];
							$TimeofComment = $row["posted_on"];
							
							$comment_id = $row['c_id'];
							
							if($row["txt_content"] != null)
							{
								$text = $row["txt_content"];
							}
							else 
							{ 
								$text = "";	
							}	
							
							if($row["pic"] != null)
							{
								$profile = $row["pic"];
							}
							else 
							{ 
								$profile = "../GenericResources/Post_Frame/Avatar%20Picture%20Circle.png";
							}
							
							?>
							<!-- div for displaying each comment repeated for each comment -->
							<div class="comment" id="<?php echo $comment_id; ?>">
							   <img src="../GenericResources/Post_Frame/Comment%20Divider.png" width="300">
							   <div class="CommentInfo"><br>
									<a aria-label="AccountPage_AvatarPic" class="Avatar">
										<img src= <?php echo $profile?>>
									</a>
									<a aria-label="OpUsername" class="Username">
										<h4 class="Username"><?php echo $username; ?></h4>
									</a>
									
									<a href="../UserPage/UserPage.php?id= <?php echo $u_id2; ?>" aria-label="OpUsername" class="Username">
										<h4 class="Username"><?php echo $username; ?></h4>
									</a>
									
									<a aria-label="DeltaTime" class="TimeOfPost">
										<h6 class="TimeOfPost"><?php echo $TimeofComment; ?> </h6>
									</a>
								</div>
						
								<div class="comment_text" >
									<?php 
										echo "$tab$text"; 
									?>
								</div>
								<img src="../GenericResources/Post_Frame/Comment%20Divider.png" width="300">
							
							
							</div>
						
						<?php
						}
					}
					else
					{
						// NO COMMENTS
					}
				
				?>
					
                </div>
				
				<div class="PostBottom">
                    <div class="Buttons">
                        <button name="UpvoteButton">
                            <img src="../GenericResources/Post_Frame/upvote.png">
                        </button>
                        <button style = "width: 20px;" name="DownvoteButton">
                            <img src="../GenericResources/Post_Frame/downvote.png">
                        </button>
						<?php echo $ranking ?>
                    </div>
					
                    <div class="Comment">
                        <img src="../GenericResources/Post_Frame/Comment%20Divider.png" width="300">
                        <form id="CommentTextField" action="../../db/commentToDB.php" method="post">
                            <input style="width: 90%; height: 28px; box-sizing: border-box; border-radius: 5px;" type="text" name="CommentText" placeholder="Share your thoughts...">
                            <input type='hidden' name='p_id' value='<?php echo "$p_id";?>'/> 
							<button style = "border-radius: 5px; height: 25px; position: relative; top: 3px;" aria-label="UploadComment">
                                <img src="../GenericResources/Post_Frame/Paper%20Airplane.png">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>