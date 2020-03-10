<?php
//Author Pierre-Alexis Barras <pyxsys>
namespace Website;
use SqlDb\Database;
require_once ('DBConfig.php');
class Upload{
	
	//Functions
	//get u_id from session.
	function fetch_user() {
		
		if (isset($_SESSION["userID"])) {
			$loggenOnUser = $_SESSION["userID"];
			//echo "Found User: ", $loggenOnUser, "<br/>";
		}else {
			 $loggenOnUser = -1;
		}
		return $loggenOnUser + 0; //ensures a numerical value is returned	
	}
	
	//Generates a random string
	public static function generate_string($input, $strength = 16) {
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	
		return $random_string;
	}
	
	
	//returns 'y' or 'n' for if there is a #hashtag found in the text.
	public static function check_for_hashtag($text){
		if(preg_match('/\#[a-zA-Z0-9]+/', $text)) return 'y';
		else return 'n';
	}
	
	
	//returns a server path to a page
	public static function get_redirect_path($value){
		
		switch($value){
		/*User Cooldown*/case(-5): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=timeout";
		/*DB Error*/ 	 case(-4): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=dberror";
		/*no user*/		 case(-3): return "/SOEN341/src/pages/SignUpPage/signUpPage.php?source=post";
		/*no post info*/ case(0): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=empty";
		/*post success*/ default: return "/SOEN341/src/pages/HomePage/HomepageBase.php";
		}
	}
	
	//returns the delay between posts for a given user id
	public static function get_user_delay($u_id){
		$user = Database::safeQuery("SELECT rating FROM users WHERE u_id=$u_id;")->fetch_assoc();
		$ratingDelay = (750 * pow(M_E,(-0.1609438*$user['rating'])) )-150;
		return floor($ratingDelay);
	}
	
	//fetches the time since the user last posted in seconds.
	public static function get_time_since_last_post($u_id){
		$currtime = time();
		$prevtime = mktime(12, 00, 00, 01, 01, 2020); //defaults to Noon Jan 1st 2020 EST (incase this is user's first post)
		$result = Database::safeQuery("SELECT posted_on FROM posts WHERE u_id=$u_id ORDER BY posted_on DESC;")->fetch_assoc();
		
		if($result != null){$prevtime = strtotime($result['posted_on']);} //set to most recent post timestamp
		//echo "Time Debug: ".date("d/m/Y : h\hm-s", $prevtime)."<br/>";
		return floor(($currtime-$prevtime)-18000); //convert to integer seconds
	}
	
	/*records posted information to DB
		//Exit Codes// - $upload_type
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
	public static function add_post_to_db($u_id, $file, $text, $fileContent){
	
		//Declare variables
		$dbconn = null; 	//db connection
		$sql = null;		//query to be passed
		$name = null;		//name of picture (if applicable)
		$upload_type = 0; 	//Return Code
		$result = null; 	//Query result
    
		$cooldown_time = Upload::get_user_delay($u_id);
		$elapsed_time = Upload::get_time_since_last_post($u_id);
		
		echo "===================================================<br/>";
		echo "Input params: (user: ".$u_id.", text: \"". $text."\", file state: ". $file. ")<br/>";
		echo "User cooldown time: ". $cooldown_time. " second(s) <br/>";
		echo "Time since last Post: ". $elapsed_time . " second(s) <br/>";
		echo "Time left: ". max($cooldown_time-$elapsed_time, 0) . " second(s) left<br/>";

		//check inputs for errors
		if($u_id == -1){return -3;}
		if($text == 'BLU::INPUT_EXCEPTION::error'){return -1;}
		if($file == 'BLU::INPUT_EXCEPTION::error'){return -2;}
		
		//Check if user is off cooldown and eligible to post
		if($elapsed_time < $cooldown_time){return -5;}
		
		//Begin checking post
		if($text != null){$upload_type += 1;} //text is set
		if($file != null){$upload_type += 2;}
		
		//Build Query for if there is an image uploaded
		if($upload_type >= 2){
			$fileType = explode("/",strtolower($file["type"]));	//[1] will be file extension
			$dbconn = Database::getConnection();
		
			//generates a unique file name
			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			do{
				$name = "images/".Upload::generate_string($permitted_chars, 16).".".$fileType[1];
				$result = Database::query("SELECT img_path FROM posts WHERE img_path = '$name';", $dbconn);
			}while($result->num_rows > 0);
			$dbconn = null; //close connection
		
			//upload picture into image directory
			if( move_uploaded_file($_FILES["postImage"]["tmp_name"], realpath(dirname(getcwd()))."/db/".$name) ){ 
				echo "success: file uploaded </br>"; 
				if($upload_type == 2){ $sql = "INSERT INTO posts (u_id, img_path) VALUES('$u_id', '$name')"; }
				if($upload_type == 3){ 
					$discover = Upload::check_for_hashtag($text);
					$sql = "INSERT INTO posts (u_id, img_path, txt_content, discoverable) VALUES($u_id, '$name', '$text', '$discover')"; 
				}
			}
			else { 
				echo "fail: file not uploaded </br>";
				return -1;
			}
		}
		
		//Build Query for if only text was submitted
		if($upload_type == 1) { 
			$discover = Upload::check_for_hashtag($text);
			$sql = "INSERT INTO posts (u_id, txt_content, discoverable) VALUES($u_id, '$text','$discover')";
		}
		
		//Insert post into database
		if($upload_type > 0){
			$result = Database::safeQuery($sql);
		}
		
		//check for error in sql result
		if (preg_match('/\berror\b/', strtolower($result))) {
			$upload_type = -4;
		}
		
		//debug
			echo "===================================================<br/>";
			echo "TYPE: ". $upload_type ."<br/>";
			echo "QUERY: ". $sql ."<br/>";
			echo "RESULT: ". $result. "<br/>";
			echo "TEXT DATA: ".$text."<br/>";
			echo "FILE DATA:" ."<br/>";
			echo "<pre>";
			print_r($file);
			echo realpath(dirname(getcwd()))."/db/" . $name;
			echo "</pre><br/>";
			
		
		return $upload_type;
	}
	
}
?>

