<?php
	namespace Website;
	use SqlDb\Database;
	
	$root = dirname(__FILE__, 4);
	require($root . '/src/db/followToDB.php');
	require($root . '/src/db/ratingToDB.php');
	require($root . '/src/db/commentToDB.php');
	require("../SettingsPage/Settings.php");
	session_start();
	
	$value = $_SESSION["userID"];
	$dbconn = Database::getConnection();
	
	if ($_POST) {
		if (isset($_POST['comment'])) {
			$New = new Comment();
			$New->WithPost();
			$_SESSION['result'] = $New->AddComment();
			$Result = $_SESSION['result'];
			//echo $Result;
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
			$New2 = new Follow();
			$New2->WithPost();
			$_SESSION['follow'] = $New2->AddFollowToDb();
			$Follow = $_SESSION['follow'];
			//echo $follow;
		}
	}
	
	if(isset($_REQUEST['id']))
	{
		$wFlag = $_REQUEST['id'];
		if($wFlag == -1)
		{
			$_SESSION['flag'] = 1;	
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1"/>
    <title>HomePageBase Feed</title>
    <link id = "style" rel="stylesheet" href="../css/FeedStyle.css"/>
	<!-- remove blue link for usernames -->
	<style>
		a { text-decoration: none; color: #000; }
	</style>
	<?php 		
		$cUserId = $_SESSION['userID'];
		$mMode = new Settings();
		$cLight = "../css/FeedStyle.css";
		$cDark = "../css/FeedStyleDark.css";
		$mResult = $mMode->GetMode($cUserId, $cLight, $cDark);
		echo "<script>document.getElementById('style').setAttribute('href', '$mResult');</script>";?>
    <?php require_once('../../db/DBConfig.php'); ?>
</head>
<body>
    <div class="FeedPage">
        <?php include '../Header/Header.php'; ?>
        <div class="Main">
            <div class="Posts">
                <div class="Contain">
				<?php
                //query 2
                $result = $dbconn->query("
                    SELECT  * FROM follow_tbl
                    JOIN posts
                    ON posts.u_id = follow_tbl.follows
                    JOIN users
                    ON posts.u_id = users.u_id
					INNER JOIN user_profile 
					on users.u_id = user_profile.u_id
                    WHERE follow_tbl.u_id = $value    
                    ORDER BY 
                    posted_on DESC;
                    ");
                $i=1;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
					$wU_id2 = $row["u_id"];
					$wP_id2 = $row['p_id'];
					$username = $row["name"];
					$wTimeofPost = $row["posted_on"];
					$wUpvote = $row["upvote"];
					$wDownvote = $row["downvote"];
					$wRanking = $wUpvote - $wDownvote;
					
					if(follow::follows($value, $wU_id2))
					{
						$followLabel = 'UnFollow';
					}
					else
					{
						$followLabel = 'Follow';
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
                        
					<div class="PostInfo"><br>
						<a href="../UserPage/UserPage.php?id=<?php echo $username; ?>" aria-label="AccountPage_AvatarPic" class="Avatar">
							<?php Profile::DisplayUserPFP($wU_id2); ?>
						</a>
						
						<a href="../UserPage/UserPage.php?id=<?php echo $username?>" aria-label="OpUsername" class="Username">
							<h4 class="Username"><?php echo $username?></h4>
						</a>
						
						<a aria-label="follow_button" class="follow">
							<div id = "follow_user">
							   <iframe name="follow" style="display:none;"></iframe>
								<form target= "follow" method="post" action="" enctype="multipart/form-data">
									<input type="hidden" name="u_id2" value="<?php echo $wU_id2;?>"> 
									<input id="followbutton<?php echo $i;?>" onclick="return changeText('followbutton<?php echo $i;?>');" type="submit" name="follow_button1" value="<?php echo $followLabel;?>" /> 
								</form>
							</div>
						</a>
						
						<a aria-label="DeltaTime" class="TimeOfPost">
							<h6 class="TimeOfPost"><?php echo $wTimeofPost; ?> </h6>
						</a>
					</div>
						
					<script type="text/javascript" src="/SOEN341/src/pages/FunctionBlocks/followJSFeed.js"></script>
					
					<?php
					$i++;
                    if($row["img_path"] != null){
                        echo '
                            <div class="PostContent">
                                <figure> 
                                    <a href="../ViewPostPage/viewPost.php?id='.$row["p_id"].'">
                                        <img style = "width: 500px;" src = \''. Database::getRoot(). $row["img_path"]. '\' />
                                    </a>
                                </figure>
                            </div>';
                        }
                        $cPromote = '../GenericResources/Post_Frame/upvote.png';
	                    $wDemote = '../GenericResources/Post_Frame/downvote.png' ;
	               	 	$like = $dbconn->query("
	                            SELECT DISTINCT rating FROM likes
	                            WHERE p_id = $wP_id2 AND u_id = $value");
	                        $mRate = 'none';
	                    while($liked = $like->fetch_assoc()) {
	                        $mRate = $liked['rating'];
	                    }

						if ($mRate == 'y')
						{
							$cPromote = '../GenericResources/Post_Frame/upvote_selected_colour.png';
						}
						else if ($mRate == 'n')
						{
							$wDemote = '../GenericResources/Post_Frame/downvote_selected_colour.png';
						}
                    echo '
                        <p> <a href="../ViewPostPage/viewPost.php?id='.$row["p_id"].'">' .$row["txt_content"]. '</a></p>
                        <div class="PostBottom">
                            <div class="Buttons">
								<form method="post"> 
									<input type="hidden" name="p_id" value="'.$row["p_id"].'"/> 
									<input type="hidden" name="u_id2" value="'.$wU_id2.'"> 
									<button id="like" name="UpvoteButton">
										<img src="'.$cPromote.'">
									</button>
									<button id="dislike" style = "width: 20px;" name="DownvoteButton">
										<img src="'.$wDemote.'">
									</button>
									'.$wRanking.'
								</form>           
							</div>
                            <div class="Comment">
                                <img src="../GenericResources/Post_Frame/Comment%20Divider.png">
                                <form id="CommentTextField" action="" method="post">
                                    <input style="width: 90%; height: 28px; box-sizing: border-box; border-radius: 5px; border: 5px;" type="text" name="CommentText" placeholder="Share your thoughts...">
                                    <input type="hidden" name="p_id" value="'.$row["p_id"].'"> 
									<button style = "border-radius: 5px; height: 25px; position: relative; top: 3px;" aria-label="UploadComment" name="comment" value="commenting">
                                        <img src="../GenericResources/Post_Frame/Paper%20Airplane.png">
                                    </button>
                                </form>
                            </div>
                        </div>
                        <img src="../GenericResources/Post_Frame/Comment%20Divider.png">';
                        echo "</br>";                   
                    }
                } else {
                    echo "Your followers haven't posted anything.";
                }
                ?> 
                </div>
            </div>
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
                <div class="Contribute">
                    <h3 class="SidebarHeaders">Contribute</h3>
                    <a href ="../CreatePostPage/createPostPage.php" class="CreatePostHyperLink">
                        <span class="CreatePostText">CREATE POST</span>
                    </a>
                </div>
                <img src="../GenericResources/Sidebar/DividerTrending.png">
                <br>
                <div class="Trending">
                    <h3 class="SidebarHeaders">Trending</h3>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <span>1. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#Number One</span>
                    </a>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <br>
                    <span>2. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#Number Two</span>
                    </a>
                    <img src="../GenericResources/Sidebar/DividerTrending.png"> 
                    <br>
                    <span>3. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#Number Three</span>
                    </a>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <br>
                    <span>4. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#Number Four</span>
                    </a>
                    <img src="../GenericResources/Sidebar/DividerTrending.png">
                    <br>
                    <span>5. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#Number Five</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
