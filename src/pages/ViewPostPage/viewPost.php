<?php
$root = dirname(__FILE__, 4);
require_once($root . '/src/db/DBConfig.php'); //Must have at the top of any file that needs db connection.
require($root . '/src/db/commentToDB.php');
require($root . '/src/db/followToDB.php');
require('viewPostClass.php');
session_start();

	if ($_POST) {
		if (isset($_POST['comment'])) {
			$New = new comment();
			$New->withPost();
			$_SESSION['com'] = $New->add_comment_to_db();
			$com = $_SESSION['com'];
			echo $com;
			if ($com != null) {
				header('Location: '.$uri. $New->get_redirect_path($com));
			} 

		}
		
		if (isset($_POST['follow_button1'])) {
			$New2 = new follow();
			$New2->withPost();
			$_SESSION['follow'] = $New2->add_follow_to_db();
			$follow = $_SESSION['follow'];
			echo $follow;
			if ($follow != null) {
				header('Location: '.$uri. $New2->get_redirect_path($follow,fetch_p_id()));
			 } 
		}
	}
?>

<!-- insert this when the image is clicked:
  <a href="viewPost.php?id=<?php //echo $p_id; ?>">
  -->
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewpost" content="width-device-width, initial-scale=1"/>
    <title>ViewPost Feed</title>
    <link rel="stylesheet" href="../css/viewPostStyle.css"/>
	<!-- remove blue link for usernames -->
	<style>
		a { text-decoration: none; color: #000; }
	</style>
</head>

<body>
	
	<!-- get current user id & connect to DB-->
	<?php
	$dbconn = Database::getConnection();
	$tab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	
	$view = new view();
	$view->withPost();
	
	$u_id = $view->fetch_user();
	$p_id = $view->fetch_p_id();

	$sql = "SELECT * FROM posts 
			INNER JOIN users on posts.u_id = users.u_id
			INNER JOIN user_profile on users.u_id = user_profile.u_id";
	
	$result = Database::query($sql, $dbconn);

	//declare variables
	$username = null;
	$TimeofPost = null;
	$image = null;
	$text = null;	
	$profile = null;
		
	// if post exists
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
				
				if(follow::follows($u_id, $u_id2))
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
						<h4 class="Username"><?php echo $username?></h4>
					</a>
					
					<a aria-label="follow_button" class="follow">
						<div id = "follow_user">
						   <iframe name="follow" style="display:none;"></iframe>
							<form target= "follow" method="post" action="" enctype="multipart/form-data">
								<input type="hidden" name="u_id2" value="<?php echo $u_id2;?>"> 
								<input id="followbutton" onclick="return changeText('followbutton');" type="submit" name="follow_button1" value="<?php echo $followLabel;?>" /> 
							</form>
						</div>
					</a>
					
					<a aria-label="DeltaTime" class="TimeOfPost">
						<h6 class="TimeOfPost"><?php echo $TimeofPost; ?> </h6>
					</a>
				</div>
				
				<script type="text/javascript" src="/SOEN341/src/pages/FunctionBlocks/followJS.js"></script>
				
				<div class="comments_wrap">
				<?php
					//Outputs a custom message depending if user was redirected to this page.
					if(isset($_GET["source"])) {
						if($_GET["source"] == 'noUserToFollow') echo "<p style = \"color:red;\"> Can't find user. Try again later.</p>";
						if($_GET["source"] == 'noP_id') echo "<p style = \"color:red;\"> Something went wrong. Try again later.</p>";
					}
				?>
				<?php
					$sql = "SELECT * FROM comments 
							INNER JOIN users ON comments.u_id = users.u_id
							INNER JOIN user_profile ON users.u_id = user_profile.u_id
							WHERE p_id = '$p_id'
							ORDER BY 
								posted_on DESC";
					$result = Database::query($sql, $dbconn);
					
					
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
						<?php
							//Outputs a custom message depending if user was redirected to this page.
							if(isset($_GET["source"])) {
								if($_GET["source"] == 'noComment') echo "<p style = \"color:red;\"> You must write something to comment.</p>";
								}
						?>
                        <img src="../GenericResources/Post_Frame/Comment%20Divider.png" width="300">
                        <form id="CommentTextField" action="" method="post">
                            <input style="width: 90%; height: 28px; box-sizing: border-box; border-radius: 5px;" type="text" name="CommentText" placeholder="Share your thoughts...">
                            <input type='hidden' name='p_id' value='<?php echo "$p_id";?>'/> 
							<button style = "border-radius: 5px; height: 25px; position: relative; top: 3px;" aria-label="UploadComment" name="comment" value="commenting">
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



