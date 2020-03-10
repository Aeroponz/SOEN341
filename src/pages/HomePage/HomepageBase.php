<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1"/>
    <title>HomePageBase Feed</title>
    <link rel="stylesheet" href="../css/FeedStyle.css"/>
    <?php require_once('../../db/DBConfig.php'); ?>
</head>
<body>
    <div class="FeedPage">
        <?php include '../Header/Header.html'; ?>
        <div class="Main">
            <div class="Posts">
                <div class="Contain">
                   <?php
                use SqlDb\Database;
                session_start();
                $value = $_SESSION["userID"];
                $dbconn = Database::getConnection();


                //query 2
                $result = $dbconn->query("
                    SELECT  * FROM follow_tbl
                    JOIN posts
                    ON posts.u_id = follow_tbl.follows
                    JOIN users
                    ON posts.u_id = users.u_id
                    WHERE follow_tbl.u_id = $value    
                    ORDER BY 
                    posted_on DESC;
                    ");
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {

                     echo '  
                        <div class="PostInfo">
                                <a href="../UserPage/UserPage.php?id='.$row["name"].'" aria-label="AccountPage_AvatarPic" class="Avatar">
                                    <img src="../GenericResources/Post_Frame/Avatar%20Picture%20Circle.png">
                                </a>
                                <a href="../UserPage/UserPage.php?id='.$row["name"].'" aria-label="OpUsername" class="Username">
                                    <h4 class="Username">' .$row["name"]. '</h4>
                                </a>
                            <a aria-label="DeltaTime" class="TimeOfPost">
                                <h6 class="TimeOfPost">' .$row["posted_on"]. '</h6>
                            </a>
                        </div> ';
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
                                <button name="UpvoteButton">
                                    <img src="../GenericResources/Post_Frame/upvote.png">
                                </button>
                                <button style = "width: 20px;" name="DownvoteButton">
                                    <img src="../GenericResources/Post_Frame/downvote.png">
                                </button>
                                <a aria-label="ExpendCommentsButton">
                                    <img src="../GenericResources/Post_Frame/CommentIcon.png">
                                </a>
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
                        </div>
                        <img src="../GenericResources/Post_Frame/Comment%20Divider.png">';
                        echo "</br>";                   
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
