<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1"/>
    <title>User Feed</title>
    <link rel="stylesheet" href="css/FeedStyle.css"/>
</head>
<body>
    <div class="FeedPage">
        <div class="BluHeader">
            <div class="header-LeftSide">
                <a aria-label="Home" class="BluLogo">
                    <img src="Resources/Top_bar/LSide.png" alt="Blu Logo">
                </a>
            </div>
            <div class="header-SearchBar">
                <form id="SearchTextField" action="">
                    <img class="SearchBarButtons" src="Resources/Top_bar/Search%20Icon.png">
                    <input class="SearchBar" type="text" name="SearchText" placeholder="Search Blu">
                </form>
            </div>
            <div class="header-RightSide">
                <div class="FeedHyperlinks">
                    <a  href="UserFeedPage.html" aria-label="UserFeed" class="Icons">
                        <img class="SearchBarButtons" src="Resources/Top_bar/home-icon.png">
                    </a>
                    <a href="PopularFeedPage.html" aria-label="PopularFeed" class="Icons">
                        <img class="SearchBarButtons" src="Resources/Top_bar/top-icon%20no%20flag.png">
                    </a>
                </div>
                <div class="divider">
                    <img style="height: 60px; width: 1px; position: absolute; top: 0;" src="Resources/Top_bar/Divider.png">
                </div>
                <div class="AccountHyperlinks">
                    <a aria-label="AccountPage" class="AvatarPicHeader">
                        <img src="Resources/Top_bar/Avatar%20Picture%20Box.png">
                    </a>
                    <a class="IconRectify" aria-label="Notifications" class="Icons">
                        <img src="Resources/Top_bar/Bell-icon.png">
                        <img src="Resources/Top_bar/Notification%20Red%20Dot.png">
                    </a>
                    <a class="IconRectify" aria-label="InstantMessaging" class="Icons">
                        <img src="Resources/Top_bar/Message%20Bubble.png">
                        <img src="Resources/Top_bar/IM%20Red%20Dot.png">
                    </a>
                    <a class="IconRectify" aria-label="AccountSettings" class="Icons">
                        <img src="Resources/Top_bar/SettingsGear.png">
                    </a>
                </div>
            </div>
        </div>
        <div class="Main">
            <div class="Posts">
                <div class="PostInfo">
                    <a aria-label="AccountPage_AvatarPic" class="Avatar">
                        <img src="Resources/Post_Frame/Avatar%20Picture%20Circle.png">
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
                        <img src="Resources/Post_Frame/215536_space-wallpaper-hd.jpg" width="500" height="375">
                        <p>#Space</p>
                    </figure>
                </div>
                <div class="PostBottom">
                    <div class="Buttons">
                        <button name="UpvoteButton">
                            <img src="Resources/Post_Frame/upvote.png">
                        </button>
                        <button style = "width: 20px;" name="DownvoteButton">
                            <img src="Resources/Post_Frame/downvote.png">
                        </button>
                        <a aria-label="ExpendCommentsButton">
                            <img src="Resources/Post_Frame/CommentIcon.png">
                        </a>
                    </div>
                    <div class="Comment">
                        <img src="Resources/Post_Frame/Comment%20Divider.png">
                        <form id="CommentTextField" action="">
                            <input style="width: 90%; height: 28px; box-sizing: border-box; border-radius: 5px;" type="text" name="CommentText" placeholder="Share your thoughts...">
                            <button style = "border-radius: 5px; height: 25px; position: relative; top: 3px;" aria-label="UploadComment">
                                <img src="Resources/Post_Frame/Paper%20Airplane.png">
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="Sidebar">
                <div class="Feeds">
                    <h3 class="SidebarHeaders">Feeds</h3>
                    <a>
                        <img src="Resources/Sidebar/home-icon.png">
                        <span>Home</span>
                        <br>
                    </a>
                    <a>
                        <img src="Resources/Sidebar/top-icon%20no%20flag.png">
                        <span>Popular</span>
                        <br>
                    </a>
                </div>
                <div class="Contribute">
                    <h3 class="SidebarHeaders">Contribute</h3>
                    <a class="CreatePostHyperLink">
                        <span class="CreatePostText">CREATE POST</span>
                    </a>
                </div>
                <div class="Trending">
                    <h3 class="SidebarHeaders">Trending</h3>
                    <span>1. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberOne</span>
                    </a>
                    <img src="Resources/Sidebar/DividerTrending.png">
                    <br>
                    <span>2. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberTwo</span>
                    </a>
                    <img src="Resources/Sidebar/DividerTrending.png">
                    <br>
                    <span>3. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberThree</span>
                    </a>
                    <img src="Resources/Sidebar/DividerTrending.png">
                    <br>
                    <span>4. </span>
                    <a class="TrendingLinks">
                        <span class="TrendingLinksText">#NumberFour</span>
                    </a>
                    <img src="Resources/Sidebar/DividerTrending.png">
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