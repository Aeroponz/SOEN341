<?php
namespace Website;
use SqlDb\Database;
$root = dirname(__FILE__, 4);
require_once ($root .'\\src\\db\\UploadClass.php');
require_once ($root .'\\src\\pages\\FunctionBlocks\\ProfileClass.php');

$wU_id = Upload::FetchUser();
$wDbConn = Database::getConnection();
$wResult = $wDbConn->query("
			SELECT  * FROM users
			WHERE users.u_id = $wU_id;
			");
			
if ($wResult->num_rows > 0) {
	while($wRow = $wResult->fetch_assoc()) {
		$wUsername = $wRow["name"];
	}
}
?>
<html>
<head>
	<style>
	a:hover{
		cursor:pointer;
	}
	</style>
</head>
<body>
	<div class="BluHeader">
            <div class="header-LeftSide">
                <a href="../HomePage/HomepageBase.php" aria-label="Home" class="BluLogo">
                    <img src="../GenericResources/Top_bar/LSide.png" alt="Blu Logo">
                </a>
            </div>
            <div class="header-SearchBar">
                <form id="SearchTextField" action="">
                    <img class="SearchBarButtons" src="../GenericResources/Top_bar/Search%20Icon.png">
                    <input class="SearchBar" type="text" name="SearchText" placeholder="Search Blu">
                </form>
            </div>
            <div class="header-RightSide">
                <div class="divider">
                    <img style="height: 60px; width: 1px; position: absolute; top: 0;" src="../GenericResources/Top_bar/Divider.png">
                </div>
                <div class="AccountHyperlinks" style="width: 210px;">
                	
                    <a href="../UserPage/UserPage.php?id=<?php echo $wUsername; ?>" aria-label="AccountPage" class="AvatarPicHeader">
                        <?php Profile::DisplayUserPFP($wU_id);?>
                    </a>
                    <a class="RightBarButtons" style="position: relative; top: -7px;" href="../HomePage/HomepageBase.php" aria-label="UserFeed" class="Icons">
                        <img  src="../GenericResources/Top_bar/home-icon.png">
                    </a>
                    <a class="RightBarButtons" style="position: relative; top: -7px;" href="../PopularFeedPage/PopularFeedPage.php" aria-label="PopularFeed" class="Icons">
                        <img src="../GenericResources/Top_bar/top-icon%20no%20flag.png">
                    </a>
                    <a class="IconRectify" aria-label="Notifications" class="Icons">
                        <img src="../GenericResources/Top_bar/Bell-icon.png">
                        <img src="../GenericResources/Top_bar/Notification%20Red%20Dot.png">
                    </a>
                    <a class="IconRectify" aria-label="AccountSettings" class="Icons" href ="../SettingsPage/SettingsPage.php">
                        <img src="../GenericResources/Top_bar/SettingsGear.png">
                    </a>
                </div>
            </div>
        </div>
</body>
</html>
