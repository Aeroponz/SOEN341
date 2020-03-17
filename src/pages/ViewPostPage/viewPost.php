<?php
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__, 4);
require_once($root . '/src/db/DBConfig.php'); //Must have at the top of any file that needs db connection.
require($root . '/src/db/commentToDB.php');
require($root . '/src/db/followToDB.php');
require($root . '/src/db/ratingToDB.php');
require('viewPostClass.php');
session_start();

	if ($_POST) {
		
		if (isset($_POST['comment'])) {
			$New = new Comment();
			$New->WithPost();
			$_SESSION['result'] = $New->AddCommentToDb();
			$Result = $_SESSION['result'];
			echo $Result;
			if ($Result != null) {
				header('Location: '.$uri. $New->GetRedirectPath($Result));
			} 
		}
		
		if (isset($_POST['UpvoteButton'])) {
			$New = new Rating();
			$New->WithPost();
			$_SESSION['up'] = $New->AddLikeToDb();
			$Up = $_SESSION['up'];
			//echo $Up;
		}
		
		if (isset($_POST['DownvoteButton'])) {
			$New = new Rating();
			$New->WithPost();
			$_SESSION['down'] = $New->AddDislikeToDb();
			$Down = $_SESSION['down'];
			//echo $Down;
		}
		
		
		if (isset($_POST['follow_button1'])) {
			$New = new Follow();
			$New->WithPost();
			$_SESSION['follow'] = $New->AddFollowToDb();
			$Follow = $_SESSION['follow'];
			//echo $Follow;
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
	$wDbConn = Database::getConnection();
	$cTab = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	
	$wView = new View();
	$wView->WithPost();
	
	$wU_id = $wView->FetchUser();
	$wP_id = $wView->FetchPId();

	$wSql = "SELECT * FROM posts 
			INNER JOIN users on posts.u_id = users.u_id
			INNER JOIN user_profile on users.u_id = user_profile.u_id";
	
	$wResult = Database::query($wSql, $wDbConn);

	//declare variables
	$wUsername = null;
	$wTimeofPost = null;
	$wImage = null;
	$wText = null;	
	$wProfile = null;
		
	// if post exists
	if ($wResult->num_rows > 0) {
		// each row
		while($wRow = $wResult->fetch_assoc()) {
			if($wRow["p_id"]== $wP_id){
				$wPoster = $wRow["u_id"];
				$wUsername = $wRow["name"];
				$wTimeofPost = $wRow["posted_on"];
				$wUpvote = $wRow["upvote"];
				$wDownvote = $wRow["downvote"];
				$wRanking = $wUpvote - $wDownvote;
				
				if(Follow::Follows($wU_id, $wPoster))
				{
					$wFollowLabel = 'UnFollow';
				}
				else
				{
					$wFollowLabel = 'Follow';
				}
				
				if($wRow["img_path"] != null)
				{
					$wImage = $wRow["img_path"];
				}
				else 
				{ 
					$wImage = null;
				}	
				
				if($wRow["txt_content"] != null)
				{
					$wText = $wRow["txt_content"];
				}
				else 
				{ 
					$wText = "";	
				}									
				
				if($wRow["pic"] != null)
				{
					$wProfile = $wRow["pic"];
				}
				else 
				{ 
					$wProfile = "../GenericResources/Post_Frame/Avatar%20Picture%20Circle.png";
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
							if($wImage != null)
							{ 
					?>
								<img src="../../db/<?php echo $wImage; ?>" alt="Image Failed to load">
				    <?php	}
							if($wText != null)
							{ 
					?>
								<p><?php echo "$cTab$wText"; ?></p>
					<?php 	}
					?>
					
					<p></p>
					</figure>
                </div>
            </div>
			<div class="Comments">
                <div class="PostInfo"><br>
					<a href="../UserPage/UserPage.php?id=<?php echo $wUsername; ?>" aria-label="AccountPage_AvatarPic" class="Avatar">
						<img class="one" src= <?php echo $wProfile?>>
					</a>
					
					<a href="../UserPage/UserPage.php?id=<?php echo $wUsername; ?>" aria-label="OpUsername" class="Username">
						<h4 class="Username"><?php echo $wUsername?></h4>
					</a>
					
					<?php
					if($wU_id !=$wPoster){?>
						
					<a aria-label="follow_button" class="follow">
						<div id = "follow_user">
						   <iframe name="follow" style="display:none;"></iframe>
							<form target= "follow" method="post" action="" enctype="multipart/form-data">
								<input type="hidden" name="u_id2" value="<?php echo $wPoster;?>"> 
								<input id="followbutton" onclick="return changeText('followbutton');" type="submit" name="follow_button1" value="<?php echo $wFollowLabel;?>" /> 
							</form>
						</div>
					</a>
					
					<?php
						}?>
					<a aria-label="DeltaTime" class="TimeOfPost">
						<h6 class="TimeOfPost"><?php echo $wTimeofPost; ?> </h6>
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
					$wSql = "SELECT * FROM comments 
							INNER JOIN users ON comments.u_id = users.u_id
							INNER JOIN user_profile ON users.u_id = user_profile.u_id
							WHERE p_id = '$wP_id'
							ORDER BY 
								posted_on DESC";
					$wResult = Database::query($wSql, $wDbConn);
					
					if ($wResult->num_rows > 0) {
						// each row
						while($wRow = $wResult->fetch_assoc()) {
							$wUsername = $wRow["name"];
							$wU_id2 = $wRow["u_id"];
							$wTimeofComment = $wRow["posted_on"];
							
							$wComment_id = $wRow['c_id'];
							
							if($wRow["txt_content"] != null)
							{
								$wText = $wRow["txt_content"];
							}
							else 
							{ 
								$wText = "";	
							}	
							
							if($wRow["pic"] != null)
							{
								$wProfile = $wRow["pic"];
							}
							else 
							{ 
								$wProfile = "../GenericResources/Post_Frame/Avatar%20Picture%20Circle.png";
							}
							
							?>
							<!-- div for displaying each comment repeated for each comment -->
							<div class="comment" id="<?php echo $wComment_id; ?>">
							
							   <img src="../GenericResources/Post_Frame/Comment%20Divider.png" width="300">
							   <div class="CommentInfo"><br>
									<a aria-label="AccountPage_AvatarPic" class="Avatar">
										<img src= <?php echo $wProfile?>>
									</a>
									<a href="../UserPage/UserPage.php?id=<?php echo $wUsername; ?>" aria-label="OpUsername" class="Username">
										<h4 class="Username"><?php echo $wUsername; ?></h4>
									</a>
									
									<a href="../UserPage/UserPage.php?id=<?php echo $wUsername; ?>" aria-label="OpUsername" class="Username">
										<h4 class="Username"><?php echo $wUsername; ?></h4>
									</a>
									
									<a aria-label="DeltaTime" class="TimeOfPost">
										<h6 class="TimeOfPost"><?php echo $wTimeofComment; ?> </h6>
									</a>
								</div>
						
								<div class="comment_text" >
									<?php 
										echo "$cTab$wText"; 
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
						<form method="post"> 
							<input type='hidden' name='p_id' value='<?php echo "$wP_id";?>'/> 
							<input type="hidden" name="u_id2" value="<?php echo "$wPoster";?>"> 
							<button name="UpvoteButton">
								<img src="../GenericResources/Post_Frame/upvote.png" id="like">
							</button>
							<button style = "width: 20px;" name="DownvoteButton">
								<img src="../GenericResources/Post_Frame/downvote.png" id="dislike">
							</button>
							<?php echo $wRanking ?>
						</form>           
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
                            <input type='hidden' name='p_id' value='<?php echo "$wP_id";?>'/> 
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



