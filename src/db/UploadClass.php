<?php
namespace Website;
use SqlDb\Database;
require_once ('DBConfig.php');
class Upload{
	
	//Functions
	//Generates a random string
	private function generate_string($input, $strength = 16) {
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
	
		return $random_string;
	}
	
	
	//returns 'y' or 'n' for if there is a #hashtag found in the text.
	private function check_for_hashtag($text){
		if(preg_match('/\#[a-zA-Z0-9]+/', $text)) return 'y';
		else return 'n';
	}
	
	
	//returns a server path to a page
	public static function get_redirect_path($value){
		
		switch($value){
		/*no user*/		 case(-3): return "/SOEN341/src/pages/SignUpPage/signUP.php?source=post";
		/*no post info*/ case(0): return "/SOEN341/src/pages/CreatePostPage/createPostPage.php?source=empty";
		/*post success*/ default: return "/SOEN341/src/pages/HomePage/HomepageBase.php";
		}
	}
	
	/*records posted information to DB
		//Error Exit Codes//
			-3 -> no user
			-2 -> bad file size/type
			-1 -> error in uploading: failure
			0 -> no data: failure
	*/
	public static function add_post_to_db($u_id,$file,$text){
	
		//Declare variables
		$dbconn = null;
		$sql = null;
		$name = null;
		$upload_type = 0; 
	
		/* upload_type key
			0 -> nothing submitted
			1 -> text only
			2 -> image only
			3 -> image + text
		*/
		
		//check inputs for errors
		if($u_id == -1){return -3;}
		if($text == "error"){return -1;}
		if($file == "error"){return -2;}
		
		if($text != null){$upload_type += 1;} //text is set
		if($file != null){$upload_type += 2;}
		
		//If there is an image uploaded
		if($upload_type >= 2){
			
			$fileType = explode("/",strtolower($file["type"]));	//[1] will be file extension
			$dbconn = Database::getConnection();
		
			//generates a unique file name
			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			do{
				$name = "images/".Upload::generate_string($permitted_chars, 16).".".$fileType[1];
				//$result = $dbconn->query("SELECT img_path FROM posts WHERE img_path = '$name';");
				$result = Database::query("SELECT img_path FROM posts WHERE img_path = '$name';", $dbconn);
			}while($result->num_rows > 0);
			$dbconn = null;
		
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
		
		//If only text was submitted
		if($upload_type == 1) { 
			$discover = Upload::check_for_hashtag($text);
			$sql = "INSERT INTO posts (u_id, txt_content, discoverable) VALUES($u_id, '$text','$discover')";
		}
		
		//Insert post into database
		if($upload_type > 0){
			Database::safeQuery($sql);
		}
		
		//debug
			echo "TYPE: ". $upload_type ."<br>";
			echo "QUERY: ". $sql ."<br>";
			echo "TEXT DATA: ".$text."<br>";
			echo "FILE DATA:" ."<br>";
			echo "<pre>";
			print_r($file);
			echo realpath(dirname(getcwd()))."/db/" . $name;
			echo"</pre>";
		
		return $upload_type;
	}
	
}
?>
