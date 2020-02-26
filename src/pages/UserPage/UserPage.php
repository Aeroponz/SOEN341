<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1"/>
    <title>User Feed</title>
    <link rel="stylesheet" href="../css/FeedStyle.css"/>
</head>
<body>
    <div class="FeedPage">
        <?php include '../Header/Header.html'; ?>
        <div class="Main">
            <div class="Posts">
                <div class="PostInfo">
                    <a aria-label="AccountPage_AvatarPic" class="Avatar">
                        <img src="../GenericResources/Post_Frame/Avatar%20Picture%20Circle.png">
                    </a>
                    <a aria-label="OpUsername" class="Username">
                        <h4 class="Username">OP Username</h4>
                    </a>
                    <a aria-label="DeltaTime" class="TimeOfPost">
                        <h6 class="TimeOfPost">Delta Time of Post</h6>
                    </a>
                </div>
                <div class="PostContent">
                    <figure>
                        <img src="../GenericResources/Post_Frame/215536_space-wallpaper-hd.jpg" width="500" height="375">
                        <p>#Space</p>
                    </figure>
                </div>
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
                            <input style="width: 90%; height: 28px; box-sizing: border-box; border-radius: 5px;" type="text" name="CommentText" placeholder="Share your thoughts...">
                            <button style = "border-radius: 5px; height: 25px; position: relative; top: 3px;" aria-label="UploadComment">
                                <img src="../GenericResources/Post_Frame/Paper%20Airplane.png">
                            </button>
                        </form>
                    </div>
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
                    <a class="CreatePostHyperLink">
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