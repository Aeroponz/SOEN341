<?php
//Author Pierre-Alexis Barras <pyxsys>
Namespace Website;
use SqlDb\Database;
require_once ('DBConfig.php');

class Upload{
	
	//returns the posted file if it is set and valid.
	//returns 'null' on no file, and "error" on errors.
	public function ValidFile($iInput) {
		if(is_uploaded_file($_FILES[$iInput]['tmp_name'])){ 
			if($_FILES[$iInput]['error'] == 0){ //file uploaded succesfully	
				//check if file 12 bytes or larger and an image?
				if( preg_match('/^image\b/',$_FILES[$iInput]['type']) && filesize($_FILES[$iInput]['tmp_name']) > 11 ){
					if(exif_imagetype($_FILES[$iInput]['tmp_name']) > 0 ) {return "sent";}
				}
			}
			else {return 'BLU::INPUT_EXCEPTION::error';}	
		}
		return null; //no file will return null.
	}
	
	//return the posted text if it is set and valid
	//returns 'null' on no text, and "error" on empty text.
	public function ValidText($iInput) {
		//text is set
		if(isset($_POST[$iInput])){
			if(!preg_match("/^\s+$/", $_POST[$iInput])){return $_POST[$iInput];}
			else {return 'BLU::INPUT_EXCEPTION::error';}
		}
		return null;
	}
	
	//get u_id from session.
	public function FetchUser() {
		
		if (isset($_SESSION["userID"])) {
			$oUser = $_SESSION["userID"];
			//echo "Found User: ", $oUser, "<br/>";
		}else {
			 $oUser = -1;
		}
		return $oUser + 0; //ensures a numerical value is returned	
	}
	
	//Generates a random string
	public static function GenerateString($iInput, $iStrength = 16) {
		$iInputLength = strlen($iInput);
		$oRandomString = '';
		for($i = 0; $i < $iStrength; $i++) {
			$wRandomCharacter = $iInput[mt_rand(0, $iInputLength - 1)];
			$oRandomString .= $wRandomCharacter;
		}
	
		return $oRandomString;
	}
	
	
	//returns 'y' or 'n' for if there is a #hashtag found in the text.
	public static function CheckForHashtag($iText){
		if(preg_match('/\#[a-zA-Z0-9]+/', $iText)) return 'y';
		else return 'n';
	}
	
	
	//returns a server path to a page
	public static function GetRedirectPath($iValue){
		
		switch($iValue){
		/*PFP DB Error*/ case(-10): return "/SOEN341/src/pages/PopularFeedPage/PopularFeedPage.php?source=error";
		/*User Cooldown*/case(-5): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=timeout";
		/*DB Error*/ 	 case(-4): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=dberror";
		/*no user*/		 case(-3): return "/SOEN341/src/pages/SignUpPage/signUpPage.php?source=post";
		/*no post info*/ case(0): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=empty";
		/*PFP Success*/ case(10): return "/SOEN341/src/pages/PopularFeedPage/PopularFeedPage.php?source=pfpsucess";
		/*post success*/ default: return "/SOEN341/src/pages/HomePage/HomepageBase.php";
		}
	}
	
	//returns the delay between posts for a given user id
	public static function GetUserDelay($wU_id){
		$wUser = Database::safeQuery("SELECT rating FROM users WHERE u_id=$wU_id;")->fetch_assoc();
		$oRatingDelay = (750 * pow(M_E,(-0.1609438*$wUser['rating'])) )-150;
		return floor($oRatingDelay);
	}
	
	//fetches the time since the user last posted in seconds.
	public static function GetTimeSinceLastPost($wU_id){
		$wCurrtime = time();
		$wPrevtime = mktime(12, 00, 00, 01, 01, 2020); //defaults to Noon Jan 1st 2020 EST (incase this is user's first post)
		$wResult = Database::safeQuery("SELECT posted_on FROM posts WHERE u_id=$wU_id ORDER BY posted_on DESC;")->fetch_assoc();
		
		if($wResult != null){$wPrevtime = strtotime($wResult['posted_on']);} //set to most recent post timestamp
		//echo "Time Debug: ".date("d/m/Y : h\hm-s", $wPrevtime)."<br/>";
		return floor(($wCurrtime-$wPrevtime)-18000); //convert to integer seconds
	}
	
	/*records posted information to DB
		//Exit Codes// - $oUploadType
			-5 -> Post not gone through, User on cooldown.
			-4 -> Failure: Database error / Bad query;
			-3 -> Failure: no user
			-2 -> Failure: bad file size/type
			-1 -> Failure: bad text
			0 -> Failure: no data
			1 -> Sucess: Text only
			2 -> Sucess: Image only
			3 -> Sucess: Image + text
	*/
	public static function AddPostToDB($wU_id, $iFile, $iText, $iFileContent){
	
		//Declare variables
		$wDBconn = null; 	//db connection
		$wSQL = null;		//query to be passed
		$wName = null;		//wName of picture (if applicable)
		$oUploadType = 0; 	//Return Code
		$wResult = null; 	//Query wResult
    
		$wCooldownTime = Upload::GetUserDelay($wU_id);
		$wElapsedTime = Upload::GetTimeSinceLastPost($wU_id);
		
		echo "===================================================<br/>";
		echo "Input params: (user: ".$wU_id.", text: \"". $iText."\", file state: ". $iFile. ")<br/>";
		echo "User cooldown time: ". $wCooldownTime. " second(s) <br/>";
		echo "Time since last Post: ". $wElapsedTime . " second(s) <br/>";
		echo "Time left: ". max($wCooldownTime-$wElapsedTime, 0) . " second(s) left<br/>";

		//check inputs for errors
		if($wU_id == -1){return -3;}
		if($iText == 'BLU::INPUT_EXCEPTION::error'){return -1;}
		if($iFile == 'BLU::INPUT_EXCEPTION::error'){return -2;}
		
		//Check if user is off cooldown and eligible to post
		if($wElapsedTime < $wCooldownTime){return -5;}
		
		//Begin checking post
		if($iText != null){$oUploadType += 1;} //text is set
		if($iFile != null){$oUploadType += 2;}
		
		//Build Query for if there is an image uploaded
		if($oUploadType >= 2){
			$wFileType = explode("/",strtolower($iFileContent["type"]));	//[1] will be file extension
			$wDBconn = Database::getConnection();
		
			//generates a unique file wName
			$cPermittedChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			do{
				$wName = "images/".Upload::GenerateString($cPermittedChars, 16).".".$wFileType[1];
				$wResult = Database::query("SELECT img_path FROM posts WHERE img_path = '$wName';", $wDBconn);
			}while($wResult->num_rows > 0);
			$wDBconn = null; //close connection
		
			//upload picture into image directory
			if( move_uploaded_file($iFileContent["tmp_name"], realpath(dirname(getcwd()))."/db/".$wName) ){ 
				echo "success: file uploaded </br>"; 
				if($oUploadType == 2){ $wSQL = "INSERT INTO posts (u_id, img_path) VALUES('$wU_id', '$wName')"; }
				if($oUploadType == 3){ 
					$wDiscover = Upload::CheckForHashtag($iText);
					$wSQL = "INSERT INTO posts (u_id, img_path, txt_content, discoverable) VALUES($wU_id, '$wName', '$iText', '$wDiscover')"; 
				}
			}
			else { 
				echo "fail: file not uploaded </br>";
				return -1;
			}
		}
		
		//Build Query for if only text was submitted
		if($oUploadType == 1) { 
			$wDiscover = Upload::CheckForHashtag($iText);
			$wSQL = "INSERT INTO posts (u_id, txt_content, discoverable) VALUES($wU_id, '$iText','$wDiscover')";
		}
		
		//Insert post into database
		if($oUploadType > 0){
			$wResult = Database::safeQuery($wSQL);
		}
		
		//check for error in wSQL wResult
		if (preg_match('/\berror\b/', strtolower($wResult))) {
			$oUploadType = -4;
		}
		
		//debug
			echo "===================================================<br/>";
			echo "TYPE: ". $oUploadType ."<br/>";
			echo "QUERY: ". $wSQL ."<br/>";
			echo "RESULT: ". $wResult. "<br/>";
			echo "TEXT DATA: ".$iText."<br/>";
			echo "FILE DATA:" ."<br/>";
			echo "<pre>";
			print_r($iFileContent);
			echo realpath(dirname(getcwd()))."/db/" . $wName;
			echo "</pre><br/>";
			
		
		return $oUploadType;
	}

}
?>

