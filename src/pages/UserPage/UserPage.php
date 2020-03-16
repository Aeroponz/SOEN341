<?php
	namespace Website;
	use SqlDb\Database;
	
	$root = dirname(__FILE__, 4);
	require($root . '/src/db/followToDB.php');
	require($root . '/src/db/ratingToDB.php');
	session_start();
	$value = $_SESSION["userID"];
	$dbconn = Database::getConnection();
	
	
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
		
		if (isset($_POST['UpvoteButton'])) {
			$New = new rating();
			$New->withPost();
			$_SESSION['up'] = $New->add_like_to_db();
			$up = $_SESSION['up'];
			echo $up;
		}
		
		if (isset($_POST['DownvoteButton'])) {
			$New = new rating();
			$New->withPost();
			$_SESSION['down'] = $New->add_dislike_to_db();
			$down = $_SESSION['down'];
			echo $down;
		}
		
		if (isset($_POST['follow_button1'])) {
			$New2 = new follow();
			$New2->withPost();
			$_SESSION['follow'] = $New2->add_follow_to_db();
			$follow = $_SESSION['follow'];
			echo $follow;
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1"/>
    <title>User Feed</title>
    <link rel="stylesheet" href="../css/FeedStyle.css"/>
	<!-- remove blue link for usernames -->
	<style>
		a { text-decoration: none; color: #000; }
	</style>
    <?php require_once('../../db/DBConfig.php'); ?> 

</head>
<body>
    <div class="FeedPage">
        <?php include '../Header/Header.html'; ?>
        <div class="Main">
            <div class="Posts">
               <div class= "Contain">
              <?php
                
                $view = $_GET['id'];

                //query 2
                $result = $dbconn->query("
					SELECT * FROM posts
                    INNER JOIN users ON users.u_id = posts.u_id
					INNER JOIN user_profile on user_profile.u_id = users.u_id
                    ORDER BY 
                    posted_on DESC;
                    ");
                $i=1;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    if ($row["name"] == $view)  {
						$u_id2 = $row["u_id"];
						$username = $row["name"];
						$TimeofPost = $row["posted_on"];
						$upvote = $row["upvote"];
						$downvote = $row["downvote"];
						$ranking = $upvote - $downvote;
						
						if(follow::follows($value, $u_id2))
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
								<a aria-label="AccountPage_AvatarPic" class="Avatar">
									<img class="one" src= <?php echo $profile?>>
								</a>
								
								<a href="../UserPage/UserPage.php?id=<?php echo $username?>" aria-label="OpUsername" class="Username">
									<h4 class="Username"><?php echo $username?></h4>
								</a>
								<?php
								if($value !=$u_id2){?>
								
								<a aria-label="follow_button" class="follow">
									<div id = "follow_user">
									   <iframe name="follow" style="display:none;"></iframe>
										<form target= "follow" method="post" action="" enctype="multipart/form-data">
											<input type="hidden" name="u_id2" value="<?php echo $u_id2;?>"> 
											<input id="followbutton<?php echo $i;?>" onclick="return changeText('followbutton<?php echo $i;?>');" type="submit" name="follow_button1" value="<?php echo $followLabel;?>" /> 
										</form>
									</div>
								</a>
								
								<?php
								}?>
								
								<a aria-label="DeltaTime" class="TimeOfPost">
									<h6 class="TimeOfPost"><?php echo $TimeofPost; ?> </h6>
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
                        echo '
                            <p> <a href="../ViewPostPage/viewPost.php?id='.$row["p_id"].'">' .$row["txt_content"]. '</a></p>
                            <div class="PostBottom">
                                <div class="Buttons">
								<form method="post"> 
									<input type="hidden" name="p_id" value="'.$row["p_id"].'"/> 
									<input type="hidden" name="u_id2" value="'.$u_id2.'"> 
									<button name="UpvoteButton">
										<img src="../GenericResources/Post_Frame/upvote.png">
									</button>
									<button style = "width: 20px;" name="DownvoteButton">
										<img src="../GenericResources/Post_Frame/downvote.png">
									</button>
									'.$ranking.'
								</form>           
							</div>
                                <div class="Comment">
                                    <img src="../GenericResources/Post_Frame/Comment%20Divider.png">
                                    <form id="CommentTextField" action="">
                                        <input style="width: 90%; height: 28px; box-sizing: border-box; border-radius: 5px; border: 5px;" type="text" name="CommentText" placeholder="Share your thoughts...">
                                        <button style = "border-radius: 5px; height: 25px; position: relative; top: 3px;" aria-label="UploadComment">
                                            <img src="../GenericResources/Post_Frame/Paper%20Airplane.png">
                                        </button>
                                    </form>
                                </div>
                            </div>';
                            echo "</br>";  
                        }
                }
                } else {
                    echo "0 results";
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
</body>
</html>
