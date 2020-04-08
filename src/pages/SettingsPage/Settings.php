<?php 
//Author: Alya Naseer
namespace Website;
use SqlDb\Database;

class Settings
{
	
 
	//This function changes to light
    static function ChangeToLight($iUserId)
    {
        Database::safeQuery("UPDATE user_profile SET dark = '' WHERE u_id = '$iUserId'");
        return "light";

    }
	
	 //This function changes to dark
    static function ChangeToDark($iUserId)
    {
        Database::safeQuery("UPDATE user_profile SET dark = '1' WHERE u_id = '$iUserId'");
        return "dark";
    }
	
	//Determine if light or dark based on value stored in DB
	static function GetMode($iUserId, $iLight, $iDark)
	{
		$wDbQuery = Database::safeQuery("SELECT dark FROM user_profile WHERE u_id = '$iUserId'");
		$wValue = $wDbQuery->fetch_assoc();
		if($wValue["dark"] == "1") {
			return $iDark;
		}
		else {
			return $iLight;
		}
	}
}
?>