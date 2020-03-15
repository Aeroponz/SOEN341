<?php 
namespace Website;
use SqlDb\Database;

class Settings
{
	
 
	//This function changes to light
    function ChangeToLight($iUserId)
    {
        $wDbQuery = Database::safeQuery("UPDATE user_profile SET dark = '' WHERE u_id = '$iUserId'");
        return "light";

    }
	
	 //This function changes to dark
    function ChangeToDark($iUserId)
    {
        $wDbQuery = Database::safeQuery("UPDATE user_profile SET dark = '1' WHERE u_id = '$iUserId'");
        return "dark";
    }
	
	//Determine if light or dark based on value stored in DB
	function GetMode($iUserId)
	{
		$wDbQuery = Database::safeQuery("SELECT dark FROM user_profile WHERE u_id = '$iUserId'");
		$wValue = $wDbQuery->fetch_assoc();
		if($wValue["dark"] == 1) {
			echo "<script type = \"text/JavaScript\">
								document.getElementById('style').setAttribute('href', 'settingsPageStyleDark.css');
								</script>";
			return true;
		}
		else {
			echo "<script type = \"text/JavaScript\">
								document.getElementById('style').setAttribute('href', 'settingsPageStyle.css');
								</script>";
			return false;
		}
	}
}
?>