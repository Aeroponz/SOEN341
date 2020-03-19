<?php
//Author: Pierre-Alexis Barras <Pyxsys>
namespace Website;
use SqlDb\Database;

class Profile {
	
	//Fetches the user's pfp in bytes and prints it to the page. if none is found, returns the default pic.
	public static function DisplayUserPFP($iU_id){
		
		//get Bytes form DB
		$wBytes = Database::safeQuery("SELECT `pic` FROM `user_profile` WHERE `u_id` = $iU_id;")->fetch_assoc();;
		
		if($wBytes['pic'] != null){ //bytes to img if not empty
		
			$wImgData = $wBytes['pic'];
			$oImg = "<img id='pfp' class='one' src='data:image/jpeg;base64, $wImgData' /><br/>";
			print($oImg);
			return 1;
			
		} else {
			//default to default avatar
			print("<img img id='pfp' class='one' src='../GenericResources/Top_bar/Avatar%20Picture%20Box.png' /><br/>");
			return 0;
		}
		
	}
	
	public static function uploadPFP($iU_id, $iFileStatus, $iImgBytes){
		
		$iImgData = base64_encode($iImgBytes); //encode pic into readable form
		echo "<br/> Preview: <br/> <img src='data:image/jpeg;base64, $iImgData' /><br/>";
		
		if($iFileStatus == 'sent'){ 
			Database::safeQuery("UPDATE `user_profile` SET `pic` = '$iImgData' WHERE `u_id` = $iU_id;");
			return 10; 
		}
		return -10;
	}
	
}
?>	